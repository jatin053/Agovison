<div class="agro-chat" data-agro-chat>
    <button class="agro-chat__toggle" type="button" data-agro-chat-toggle aria-expanded="false" aria-label="Open AgroVision chat">
        <span class="agro-chat__toggle-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 6.5h14v9H9l-4 3v-12Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M8.5 10h7M8.5 13h4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </span>
        <span>Ask AgroVision</span>
    </button>

    <section class="agro-chat__panel" data-agro-chat-panel aria-label="AgroVision support chat">
        <header class="agro-chat__header">
            <div>
                <strong>AgroVision Assistant</strong>
                <small>Ask about crops, soil, weather, yield, disease, fertilizer, reports, or APIs.</small>
            </div>
            <button type="button" data-agro-chat-close aria-label="Close chat">×</button>
        </header>

        <div class="agro-chat__messages" data-agro-chat-messages>
            <div class="agro-chat__message agro-chat__message--bot">
                <p>Hi! Ask me anything about AgroVision. Try: “Which API is needed?”, “How disease detection works?”, or “How soil profile works?”</p>
            </div>
        </div>

        <div class="agro-chat__quick">
            <button type="button" data-agro-chat-question="Which Google APIs do I need?">Google APIs</button>
            <button type="button" data-agro-chat-question="How does disease detection work?">Disease</button>
            <button type="button" data-agro-chat-question="How does soil profile work?">Soil</button>
            <button type="button" data-agro-chat-question="How do farm reports work?">Reports</button>
        </div>

        <form class="agro-chat__form" data-agro-chat-form>
            <input type="text" data-agro-chat-input placeholder="Type your question..." autocomplete="off">
            <button type="submit">Send</button>
        </form>
    </section>
</div>
