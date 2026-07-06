@extends('dashboard_ui.layout')

@section('title', 'Soil Health Check')
@section('subtitle', 'Understand nutrient balance, soil vitality, and recovery steps using a single consistent dashboard view.')

@section('header_actions')
    <button class="dash-button dash-button--ghost" type="button">Upload Soil Report</button>
@endsection

@section('content')
    <div class="dash-content-stack">
        <section class="dash-grid dash-grid--2">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Field Sample</p>
                        <h2>Enter soil test details</h2>
                    </div>
                </div>

                <div class="dash-field-grid">
                    <label class="dash-field">
                        <span>Field Name</span>
                        <input class="dash-input" type="text" value="North Plot">
                    </label>
                    <label class="dash-field">
                        <span>Soil Texture</span>
                        <select class="dash-select">
                            <option selected>Loamy</option>
                            <option>Clay</option>
                            <option>Sandy</option>
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Organic Carbon (%)</span>
                        <input class="dash-input" type="text" value="0.84">
                    </label>
                    <label class="dash-field">
                        <span>pH Value</span>
                        <input class="dash-input" type="text" value="6.4">
                    </label>
                    <label class="dash-field">
                        <span>Electrical Conductivity</span>
                        <input class="dash-input" type="text" value="0.21 dS/m">
                    </label>
                    <label class="dash-field">
                        <span>Moisture Level</span>
                        <input class="dash-input" type="text" value="62%">
                    </label>
                    <label class="dash-field">
                        <span>Nitrogen</span>
                        <select class="dash-select">
                            <option selected>Low</option>
                            <option>Medium</option>
                            <option>High</option>
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Phosphorus</span>
                        <select class="dash-select">
                            <option selected>Medium</option>
                            <option>Low</option>
                            <option>High</option>
                        </select>
                    </label>
                    <label class="dash-field">
                        <span>Potassium</span>
                        <select class="dash-select">
                            <option selected>High</option>
                            <option>Medium</option>
                            <option>Low</option>
                        </select>
                    </label>
                    <label class="dash-field dash-field--wide">
                        <span>Observation Notes</span>
                        <textarea class="dash-textarea" rows="4">Mild compaction in one corner, moisture retention otherwise good.</textarea>
                    </label>
                </div>

                <div class="dash-card__footer">
                    <button class="dash-button dash-button--primary dash-button--full" type="button">Analyze Soil Health</button>
                </div>
            </article>

            <article class="dash-card dash-card--soft-green">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Health Overview</p>
                        <h2>North Plot score</h2>
                    </div>
                    <span class="dash-badge dash-badge--green">Improving</span>
                </div>

                <div class="dash-result-hero">
                    <div class="dash-score-card dash-score-card--center">
                        <div class="dash-score-ring" style="--progress: 74">
                            <strong>74</strong>
                        </div>
                        <p>Soil health score</p>
                    </div>
                    <div class="dash-detail-list">
                        <div><span>Texture</span><strong>Loamy</strong></div>
                        <div><span>pH</span><strong>6.4 Optimal</strong></div>
                        <div><span>Organic Carbon</span><strong>0.84% Good</strong></div>
                        <div><span>Moisture Retention</span><strong>Stable</strong></div>
                    </div>
                </div>

                <div class="dash-chip-row">
                    <span class="dash-chip dash-chip--red">Nitrogen Low</span>
                    <span class="dash-chip dash-chip--amber">Phosphorus Medium</span>
                    <span class="dash-chip dash-chip--green">Potassium Strong</span>
                </div>

                <div class="dash-highlight">
                    <strong>Recovery suggestion</strong>
                    <p>Increase nitrogen support with split applications, add farmyard manure, and use mulching to keep the current moisture advantage.</p>
                </div>
            </article>
        </section>

        <section class="dash-grid dash-grid--3">
            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Key Findings</p>
                        <h2>Current soil signals</h2>
                    </div>
                </div>
                <ul class="dash-check-list">
                    <li>Soil structure supports healthy root spread.</li>
                    <li>Organic carbon is above the safe baseline.</li>
                    <li>Nitrogen is the main limiting nutrient right now.</li>
                    <li>No major salinity issue detected in the sample.</li>
                </ul>
            </article>

            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Recommended Actions</p>
                        <h2>Next steps</h2>
                    </div>
                </div>
                <div class="dash-steps">
                    <div class="dash-step"><span>1</span><div><strong>Add organic matter</strong><p>Apply compost or FYM before the next tillage cycle.</p></div></div>
                    <div class="dash-step"><span>2</span><div><strong>Support nitrogen</strong><p>Use split nitrogen application to avoid loss and improve uptake.</p></div></div>
                    <div class="dash-step"><span>3</span><div><strong>Retest after 30 days</strong><p>Compare nutrient changes before the next crop decision.</p></div></div>
                </div>
            </article>

            <article class="dash-card">
                <div class="dash-card__header">
                    <div>
                        <p class="dash-eyebrow">Recent Samples</p>
                        <h2>Last 3 tests</h2>
                    </div>
                </div>
                <div class="dash-list">
                    <div class="dash-list__item"><div><strong>North Plot</strong><p>74 score | Jun 09, 2026</p></div></div>
                    <div class="dash-list__item"><div><strong>West Patch</strong><p>69 score | May 28, 2026</p></div></div>
                    <div class="dash-list__item"><div><strong>South Field</strong><p>81 score | May 10, 2026</p></div></div>
                </div>
            </article>
        </section>
    </div>
@endsection
