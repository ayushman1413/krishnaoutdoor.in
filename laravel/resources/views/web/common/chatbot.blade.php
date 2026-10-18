@php
    // Mumbai number on Mumbai/Thane pages, Ahmedabad head office elsewhere.
    $chatOffice = \App\Services\SeoResolver::officeFor($seo ?? null);
@endphp

<button aria-label="Open Krishna AI assistant" class="chatbot" id="chatbot" type="button">
<span aria-hidden="true" class="cute-robot">
<span class="robot-antenna"></span>
<span class="robot-head">
<i class="robot-eye"></i><i class="robot-eye"></i>
<b class="robot-smile"></b>
</span>
<span class="robot-ear robot-ear-left"></span>
<span class="robot-ear robot-ear-right"></span>
<span class="robot-body"></span>
</span>
<span class="chatbot-ping"></span>
</button>
<div aria-hidden="true" class="chat-panel" id="chatPanel">
<div class="chat-head">
<div class="chat-brand">
<span aria-hidden="true" class="chat-brand-icon">
<span class="brand-antenna"></span>
<span class="brand-face"><i></i><i></i><b></b></span>
</span>
<div class="chat-brand-copy">
<b>Krishna AI</b>
<small><i></i> ONLINE</small>
</div>
</div>
<button aria-label="Minimize chat" id="chatClose" type="button">↓</button>
</div>
<div class="chat-body">
<div class="chat-messages" id="chatMessages">
<div class="msg-row bot"><div class="msg-bubble">Hello! I’m Krishna AI. How can I help you?</div></div>
</div>

<form class="chat-composer" id="chatComposer">
<input aria-label="Ask Krishna AI" autocomplete="off" id="chatInput" placeholder="Type a message…" type="text"/>
<button aria-label="Send message" type="submit">Send</button>
</form>
<div class="chat-direct"><span>Need a person?</span><a href="tel:{{ $chatOffice['phone'] }}" aria-label="Call us on {{ $chatOffice['phone_display'] }}">Call us</a><a href="mailto:info@krishnaoutdoor.in">Email</a></div>
</div>
</div>
<div class="cursor" id="cursor"></div><div class="cursor-ring" id="cursorRing"></div>
