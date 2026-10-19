/*
 * Krishna AI chat widget. Loaded by main.js on the first interaction with
 * the chat button (hover, focus, click) or once the page is idle, so it is
 * not part of the initial page load.
 */
(function () {
const $ = (s,root=document)=>root.querySelector(s);
const $$ = (s,root=document)=>[...root.querySelectorAll(s)];
const chatbot=$('#chatbot'),chatPanel=$('#chatPanel'),chatClose=$('#chatClose'),chatMessages=$('#chatMessages'),chatComposer=$('#chatComposer'),chatInput=$('#chatInput');
if(chatbot && chatPanel){
 const pad=n=>String(n).padStart(2,'0');
 const timeNow=()=>{const d=new Date();let h=d.getHours(),m=d.getMinutes();const ap=h>=12?'PM':'AM';h=h%12||12;return `${h}:${pad(m)} ${ap}`};
 let chatStartedAt=null;
 const scrollBottom=()=>{if(chatMessages) chatMessages.scrollTop=chatMessages.scrollHeight};
 const stamp=(label='')=>{const el=document.createElement('div');el.className='msg-time';el.textContent=label||timeNow();return el};
 const avatar=()=>`<span class="msg-avatar"><span class="mini-bot"><i></i><i></i><b></b></span></span>`;
 const addMessage=(text,who='bot',withTime=true)=>{
   if(!chatMessages) return;
   const row=document.createElement('div'); row.className=`msg-row ${who}`;
   if(who==='bot') row.innerHTML=`${avatar()}<div class="msg-stack"><div class="msg-bubble">${text}</div></div>`;
   else row.innerHTML=`<div class="msg-stack"><div class="msg-bubble">${text}</div></div>`;
   chatMessages.appendChild(row);
   scrollBottom(); return row;
 };
 const showThinking=()=>{
   const row=document.createElement('div');row.className='msg-row bot thinking-row';
   row.innerHTML=`${avatar()}<div class="msg-stack"><div class="msg-bubble thinking-bubble"><span class="thinking-label">Thinking</span><span class="thinking-dots"><i></i><i></i><i></i></span></div></div>`;
   chatMessages?.appendChild(row);scrollBottom();return row;
 };
 // ---- Krishna AI: server-side brain with memory (see app/Services/Chat) ----
 const esc=t=>String(t).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
 const fmt=t=>esc(t).replace(/\*\*(.+?)\*\*/g,'<strong>$1</strong>').replace(/\n/g,'<br>');
 const safeHref=h=>/^(\/|https?:\/\/|tel:|mailto:)/.test(h)?h:'/';
 const linkList=links=>links&&links.length?`<div class="chat-link-list">${links.map(l=>`<a href="${esc(safeHref(l[1]))}">${esc(l[0])}</a>`).join(' ')}</div>`:'';
 let visitorId=null;
 try{visitorId=localStorage.getItem('ko_chat_vid')}catch(e){}
 const saveVisitor=id=>{if(!id||id===visitorId)return;visitorId=id;try{localStorage.setItem('ko_chat_vid',id)}catch(e){}};
 let csrf=null;
 const getToken=()=>csrf?Promise.resolve(csrf):fetch('/csrf-token',{credentials:'same-origin',headers:{Accept:'application/json'}}).then(r=>r.json()).then(j=>(csrf=j.token));
 const api=(url,payload)=>getToken().then(t=>fetch(url,{method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/json',Accept:'application/json','X-CSRF-TOKEN':t},body:JSON.stringify(Object.assign({visitor:visitorId,path:location.pathname,title:document.title},payload||{}))}).then(r=>{if(r.status===419){csrf=null;throw new Error('csrf')}if(!r.ok)throw new Error('http '+r.status);return r.json()}));
 const clearChips=()=>$$('.chat-chips',chatMessages).forEach(c=>c.remove());
 const showChips=chips=>{
   clearChips();if(!chips||!chips.length||!chatMessages)return;
   const wrap=document.createElement('div');wrap.className='chat-chips';
   chips.forEach(c=>{const b=document.createElement('button');b.type='button';b.className='chat-chip';b.textContent=c;b.addEventListener('click',()=>send(c));wrap.appendChild(b)});
   chatMessages.appendChild(wrap);scrollBottom();
 };
 const botSay=(data)=>{addMessage(fmt(data.reply||data.text)+linkList(data.links),'bot',true);showChips(data.chips)};
 const send=(text)=>{
   const value=(text||'').trim();if(!value)return;
   clearChips();addMessage(esc(value),'user');
   const thinking=showThinking();const started=Date.now();
   api('/chat/message',{message:value}).then(data=>{
     saveVisitor(data.visitor);
     const wait=Math.max(0,Math.min(1100,350+data.reply.length*3)-(Date.now()-started));
     setTimeout(()=>{thinking.remove();botSay(data);if(data.lead&&typeof window.koTrack==='function'){window.koTrack('generate_lead',{form_name:'chatbot'})}},wait);
   }).catch(()=>{
     thinking.remove();
     addMessage('I am having trouble connecting right now. You can call the team on <a href="tel:+919879616411">+91 98796 16411</a> (Ahmedabad) or <a href="tel:+919920011574">+91 99200 11574</a> (Mumbai), or use the <a href="/free-site-list">free site list form</a>.','bot',true);
   });
 };
 let historyLoaded=false;
 const loadHistory=()=>{
   if(historyLoaded)return;historyLoaded=true;
   const q='?visitor='+encodeURIComponent(visitorId||'')+'&path='+encodeURIComponent(location.pathname);
   fetch('/chat/history'+q,{credentials:'same-origin',headers:{Accept:'application/json'}}).then(r=>r.json()).then(data=>{
     saveVisitor(data.visitor);
     if(data.messages&&data.messages.length){
       $$('.msg-row',chatMessages).forEach(r=>r.remove());
       data.messages.forEach(m=>addMessage(fmt(m.text),m.role==='user'?'user':'bot',false));
       addMessage('Welcome back. Where were we? You can pick up from here or ask something new.','bot',true);
     }else if(data.welcome){
       $$('.msg-row',chatMessages).forEach(r=>r.remove());
       botSay(data.welcome);
     }
   }).catch(()=>{});
 };
 const closeChat=()=>{chatPanel.classList.remove('open');chatPanel.setAttribute('aria-hidden','true');chatPanel.inert=true;chatbot.setAttribute('aria-expanded','false')};
 const openChat=()=>{const wasOpen=chatPanel.classList.contains('open');chatPanel.classList.toggle('open');chatPanel.setAttribute('aria-hidden',wasOpen?'true':'false');chatPanel.inert=wasOpen;chatbot.setAttribute('aria-expanded',wasOpen?'false':'true');if(!wasOpen){loadHistory();if(!chatStartedAt) chatStartedAt=timeNow();setTimeout(()=>chatInput?.focus(),220)}scrollBottom()};
 chatbot.addEventListener('click',openChat);
 chatClose?.addEventListener('click',e=>{e.stopPropagation();closeChat()});
 document.addEventListener('keydown',e=>{if(e.key==='Escape') closeChat()});
 document.addEventListener('click',e=>{if(chatPanel.classList.contains('open')&&!e.target.closest('#chatPanel')&&!e.target.closest('#chatbot')) closeChat()});
 $$('[data-chat]').forEach(b=>b.addEventListener('click',()=>{send(b.textContent.replace('↗','').trim())}));
 chatComposer?.addEventListener('submit',e=>{e.preventDefault();const value=chatInput?.value.trim();if(!value)return;chatInput.value='';send(value)});
 if(chatComposer&&!$('.chat-privacy',chatPanel)){const n=document.createElement('p');n.className='chat-privacy';n.textContent='Chats are saved so our team can follow up. Type "forget me" to delete yours.';chatComposer.insertAdjacentElement('afterend',n)}
 if(chatMessages && !chatMessages.querySelector('.chat-day')){const day=document.createElement('div');day.className='chat-day';day.textContent=`Today • ${timeNow()}`;chatMessages.prepend(day);$$('.msg-row.bot',chatMessages).forEach(row=>{if(!row.querySelector('.msg-avatar')) row.insertAdjacentHTML('afterbegin',avatar());let stack=row.querySelector('.msg-stack');if(!stack){const bubble=row.querySelector('.msg-bubble');stack=document.createElement('div');stack.className='msg-stack';if(bubble){bubble.parentNode.removeChild(bubble);stack.appendChild(bubble)}row.appendChild(stack)}})}
}
window.KO_CHAT_READY = true;
})();
