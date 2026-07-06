import os
import numpy as np
import tensorflow as tf
from tensorflow.keras import layers, models
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from sklearn.model_selection import train_test_split
import matplotlib.pyplot as plt

# Define paths
dataset_path = r"C:\Users\Joel\Desktop\bin\Soil-Type-1\Soil Types"
output_model_path = r"C:\Users\Joel\Desktop\bin\Soil-Type-1\soil_type_model.h5"

def create_soil_type_classifier():
    # 1. Organize and prepare the dataset
    
    # Create train/validation directories if they don't exist
    train_dir = os.path.join(dataset_path, 'train')
    val_dir = os.path.join(dataset_path, 'validation')
    
    if not os.path.exists(train_dir):
        os.makedirs(train_dir)
    if not os.path.exists(val_dir):
        os.makedirs(val_dir)
    
    # Create subdirectories for each soil type in train and validation folders
    soil_types = [d for d in os.listdir(dataset_path) if os.path.isdir(os.path.join(dataset_path, d)) 
                  and d not in ['train', 'validation']]
    
    for soil_type in soil_types:
        train_soil_dir = os.path.join(train_dir, soil_type)
        val_soil_dir = os.path.join(val_dir, soil_type)
        
        if not os.path.exists(train_soil_dir):
            os.makedirs(train_soil_dir)
        if not os.path.exists(val_soil_dir):
            os.makedirs(val_soil_dir)
    
    # 2. Split data into training and validation sets (80/20 split)
    for soil_type in soil_types:
        soil_dir = os.path.join(dataset_path, soil_type)
        image_files = [f for f in os.listdir(soil_dir) if f.endswith(('.jpg', '.jpeg', '.png'))]
        
        # Shuffle image files
        np.random.shuffle(image_files)
        
        # Split the dataset (80% train, 20% validation)
        train_files = image_files[:int(0.8 * len(image_files))]
        val_files = image_files[int(0.8 * len(image_files)):]
        
        # Copy files to train directory
        import shutil
        for file in train_files:
            src = os.path.join(soil_dir, file)
            dst = os.path.join(train_dir, soil_type, file)
            shutil.copy(src, dst)
        
        # Copy files to validation directory
        for file in val_files:
            src = os.path.join(soil_dir, file)
            dst = os.path.join(val_dir, soil_type, file)
            shutil.copy(src, dst)
    
    print(f"Dataset organized into {len(soil_types)} categories: {', '.join(soil_types)}")
    
    # 3. Set up data augmentation and preprocessing
    train_datagen = ImageDataGenerator(
        rescale=1./255,
        rotation_range=20,
        width_shift_range=0.2,
        height_shift_range=0.2,
        shear_range=0.2,
        zoom_range=0.2,
        horizontal_flip=True,
        fill_mode='nearest'
    )
    
    validation_datagen = ImageDataGenerator(rescale=1./255)
    
    # Set target image size
    img_height, img_width = 224, 224
    batch_size = 32
    
    # Create data generators
    train_generator = train_datagen.flow_from_directory(
        train_dir,
        target_size=(img_height, img_width),
        batch_size=batch_size,
        class_mode='categorical'
    )
    
    validation_generator = validation_datagen.flow_from_directory(
        val_dir,
        target_size=(img_height, img_width),
        batch_size=batch_size,
        class_mode='categorical'
    )
    
    # 4. Create and compile the model
    model = models.Sequential([
        # Base convolutional layers
        layers.Conv2D(32, (3, 3), activation='relu', input_shape=(img_height, img_width, 3)),
        layers.MaxPooling2D((2, 2)),
        layers.Conv2D(64, (3, 3), activation='relu'),
        layers.MaxPooling2D((2, 2)),
        layers.Conv2D(128, (3, 3), activation='relu'),
        layers.MaxPooling2D((2, 2)),
        layers.Conv2D(128, (3, 3), activation='relu'),
        layers.MaxPooling2D((2, 2)),
        
        # Flatten and dense layers
        layers.Flatten(),
        layers.Dropout(0.5),  # Reduce overfitting
        layers.Dense(512, activation='relu'),
        layers.Dense(len(soil_types), activation='softmax')  # Output neurons equal to number of soil types
    ])
    
    # Compile the model
    model.compile(
        optimizer='adam',
        loss='categorical_crossentropy',
        metrics=['accuracy']
    )
    
    # 5. Train the model
    epochs = 15
    
    history = model.fit(
        train_generator,
        steps_per_epoch=train_generator.samples // batch_size,
        epochs=epochs,
        validation_data=validation_generator,
        validation_steps=validation_generator.samples // batch_size
    )
    
    # 6. Save the model
    model.save(output_model_path)
    print(f"Model saved to {output_model_path}")
    
    # 7. Plot training results
    acc = history.history['accuracy']
    val_acc = history.history['val_accuracy']
    loss = history.history['loss']
    val_loss = history.history['val_loss']
    
    plt.figure(figsize=(12, 4))
    plt.subplot(1, 2, 1)
    plt.plot(acc, label='Training Accuracy')
    plt.plot(val_acc, label='Validation Accuracy')
    plt.xlabel('Epoch')
    plt.ylabel('Accuracy')
    plt.legend()
    
    plt.subplot(1, 2, 2)
    plt.plot(loss, label='Training Loss')
    plt.plot(val_loss, label='Validation Loss')
    plt.xlabel('Epoch')
    plt.ylabel('Loss')
    plt.legend()
    
    plt.tight_layout()
    plt.savefig(os.path.join(dataset_path, 'training_results.png'))
    plt.show()
    
    # Return model and class indices for later use
    return model, train_generator.class_indices

def predict_soil_type(model, image_path, class_indices):
    """
    Predict soil type for a given image
    """
    img_height, img_width = 224, 224
    
    # Load and preprocess the image
    img = tf.keras.preprocessing.image.load_img(
        image_path, target_size=(img_height, img_width)
    )
    img_array = tf.keras.preprocessing.image.img_to_array(img)
    img_array = tf.expand_dims(img_array, 0) / 255.0
    
    # Make prediction
    predictions = model.predict(img_array)
    score = tf.nn.softmax(predictions[0])
    
    # Get the predicted class and confidence
    predicted_class = np.argmax(score)
    confidence = 100 * np.max(score)
    
    # Map class index to soil type name (reverse the class_indices dictionary)
    class_names = {v: k for k, v in class_indices.items()}
    predicted_soil_type = class_names[predicted_class]
    
    print(f"This image is classified as: {predicted_soil_type} with {confidence:.2f}% confidence")
    return predicted_soil_type, confidence

# Run the model creation and training
if __name__ == "__main__":
    model, class_indices = create_soil_type_classifier()
    
    # Example of how to use the model for prediction
    # (you would replace this with your own test image)
    test_image = input("Enter path to a test image: ")
    if os.path.exists(test_image):
        predict_soil_type(model, test_image, class_indices)
    else:
        print("Invalid image path. You can test the model later with a valid image.")