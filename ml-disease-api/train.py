import argparse
import json
from pathlib import Path

import tensorflow as tf


def main() -> None:
    parser = argparse.ArgumentParser(description="Train the AgroVision plant disease classifier.")
    parser.add_argument("dataset", help="Folder containing one subfolder per class (Crop___Disease).")
    parser.add_argument("--epochs", type=int, default=12)
    parser.add_argument("--image-size", type=int, default=224)
    parser.add_argument("--batch-size", type=int, default=32)
    args = parser.parse_args()

    dataset = Path(args.dataset)
    if not dataset.is_dir():
        raise SystemExit(f"Dataset folder not found: {dataset}")

    train_ds = tf.keras.utils.image_dataset_from_directory(
        dataset, validation_split=0.2, subset="training", seed=42,
        image_size=(args.image_size, args.image_size), batch_size=args.batch_size,
    )
    val_ds = tf.keras.utils.image_dataset_from_directory(
        dataset, validation_split=0.2, subset="validation", seed=42,
        image_size=(args.image_size, args.image_size), batch_size=args.batch_size,
    )
    class_names = train_ds.class_names
    augment = tf.keras.Sequential([
        tf.keras.layers.RandomFlip("horizontal"),
        tf.keras.layers.RandomRotation(0.1),
        tf.keras.layers.RandomZoom(0.1),
        tf.keras.layers.RandomContrast(0.1),
    ])
    base = tf.keras.applications.MobileNetV2(
        input_shape=(args.image_size, args.image_size, 3), include_top=False,
        weights="imagenet", pooling="avg",
    )
    base.trainable = False
    inputs = tf.keras.Input((args.image_size, args.image_size, 3))
    x = augment(inputs)
    x = tf.keras.applications.mobilenet_v2.preprocess_input(x)
    x = base(x, training=False)
    x = tf.keras.layers.Dropout(0.25)(x)
    outputs = tf.keras.layers.Dense(len(class_names), activation="softmax")(x)
    model = tf.keras.Model(inputs, outputs)
    model.compile(optimizer="adam", loss="sparse_categorical_crossentropy", metrics=["accuracy"])

    callbacks = [
        tf.keras.callbacks.EarlyStopping(patience=3, restore_best_weights=True),
        tf.keras.callbacks.ReduceLROnPlateau(patience=2),
    ]
    model.fit(train_ds.prefetch(tf.data.AUTOTUNE), validation_data=val_ds.prefetch(tf.data.AUTOTUNE),
              epochs=args.epochs, callbacks=callbacks)

    output = Path(__file__).resolve().parent / "model"
    output.mkdir(exist_ok=True)
    model.save(output / "plant_disease_model.keras")
    (output / "labels.json").write_text(json.dumps(class_names, indent=2), encoding="utf-8")
    print(f"Saved model with {len(class_names)} classes to {output}")


if __name__ == "__main__":
    main()
