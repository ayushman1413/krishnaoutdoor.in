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
 const L=Object.assign({
   home:'index.html',about:'about.html',services:'services.html',ooh:'ooh-media.html',transit:'transit-media.html',digital:'digital-media.html',network:'network.html',location:'network.html#presence',campaign:'projects.html#campaigns',work:'projects.html',careers:'careers.html',enquire:'contact.html'
 },window.KR_ROUTES||{});
 const link=(href,label)=>`<a href="${href}">${label}</a>`;
 const pageLinks=()=>`<div class="chat-link-list">${link(L.home,'Home')} ${link(L.about,'About Us')} ${link(L.services,'Media Solutions')} ${link(L.ooh,'OOH Media')} ${link(L.transit,'Transit Media')} ${link(L.digital,'Digital Media')} ${link(L.location,'Location')} ${link(L.network,'Our Network')} ${link(L.campaign,'Campaign')} ${link(L.work,'Our Work')} ${link(L.careers,'Careers')} ${link(L.enquire,'Enquire Now')}</div>`;
 const contactInfo=()=>`<strong>Contact Krishna Outdoor</strong><br>
Ahmedabad: ${link('tel:+919879616411','+91 98796 16411')} · ${link('mailto:info@krishnaoutdoor.in','info@krishnaoutdoor.in')}<br>
Aakanksha Complex, 403-404, Netaji Rd, nr. Railway Crossing, opposite Andani Hyper Market, Muslim Society, Navrangpura, Ahmedabad, Gujarat – 380009, India.
<br><br>
Mumbai: ${link('tel:+919920011574','+91 99200 11574')} · ${link('mailto:info.team@krishnaoutdoor.in','info.team@krishnaoutdoor.in')}<br>
701, 702 Morya Blue Moon, Next to Moniginis Cake Factory, Off New Link Road, Opp. Citi Mall, Andheri West, Mumbai, Maharashtra – 400053, India.
<br><br>
${link(L.enquire,'Open Enquire Now')}`;
 const pageName=(document.title||'').toLowerCase();
 const getReply=(input)=>{
   const q=input.toLowerCase().replace(/[^a-z0-9@.+#& -]/g,' ').replace(/\s+/g,' ').trim();
   const has=(...terms)=>terms.some(t=>q.includes(t));
   if(has('all page','all pages','page link','page links','website link','links')) return `Here are all the website pages:<br>${pageLinks()}`;
   if(has('contact','phone','mobile','number','call','email','mail','enquire','enquiry','quote','quotation','address','office','details')) return contactInfo();
   if(has('hi','hello','hey','hii','namaste','good morning','good afternoon','good evening')) return `Hello! I’m Krishna AI. I can guide you through every page of Krishna Outdoor.<br>${pageLinks()}`;
   if(has('name','who are you','your name')) return `I’m Krishna AI, the virtual assistant for Krishna Outdoor. I can guide you through every section and page of this website.<br>${link(L.enquire,'Enquire Now')}`;
   if(has('home','homepage')) return `The Home page covers Krishna Outdoor’s outdoor advertising story, solutions, campaigns, network and enquiry path.<br>${link(L.home,'Open Home')}`;
   if(has('about','company','history','legacy','years','experience')) return `The About page explains Krishna Outdoor’s journey, leadership, 43+ years of experience and media legacy.<br>${link(L.about,'Open About Us')}`;
   if(has('service','services','media solution','media solutions')) return `Media Solutions includes OOH Media, Transit Media and Digital Media. The wider offering also covers print & electronic media, branding and digital marketing.<br>${link(L.services,'Open Media Solutions')} · ${link(L.ooh,'OOH')} · ${link(L.transit,'Transit')} · ${link(L.digital,'Digital')}`;
   if(has('ooh','hoarding','hoardings','billboard','billboards','outdoor')) return `OOH Media covers outdoor formats such as hoardings and billboards.<br>${link(L.ooh,'Open OOH Media')} · ${link(L.enquire,'Enquire Now')}`;
   if(has('transit','bus','train','railway','metro','shelter')) return `Transit Media covers buses, bus shelters, trains and railway environments.<br>${link(L.transit,'Open Transit Media')} · ${link(L.enquire,'Enquire Now')}`;
   if(has('digital','dooh','screen','digital billboard')) return `Digital Media and DOOH cover dynamic digital billboard and screen-led advertising.<br>${link(L.digital,'Open Digital Media')} · ${link(L.enquire,'Enquire Now')}`;
   if(has('print','newspaper','press','radio','electronic media')) return `Print & Electronic Media can include newspaper, press and radio formats as part of an integrated media approach.<br>${link(L.services,'Open Media Solutions')} · ${link(L.enquire,'Enquire Now')}`;
   if(has('location','where','city','ahmedabad','mumbai','thane','rajasthan','market')) return `Our Location / Network pages cover Ahmedabad, Mumbai, Thane and Rajasthan market presence and media opportunities.<br>${link(L.location,'Open Location')} · ${link(L.network,'Open Our Network')}`;
   if(has('network','presence','sites','cities')) return `Our Network page explains Krishna Outdoor’s media presence, market coverage, hoardings, buses, shelters and train opportunities across key markets.<br>${link(L.network,'Open Our Network')}`;
   if(has('project','projects','work','campaign','portfolio','case study')) return `Our Work shows campaign examples and project work. The Campaign section is also available directly.<br>${link(L.campaign,'Open Campaign')} · ${link(L.work,'Open Our Work')}`;
   if(has('career','careers','job','jobs','join','opening')) return `The Careers page contains the opportunity/application section for roles across sales, operations, design, client servicing, digital and administration.<br>${link(L.careers,'Open Careers')}`;
   if(has('price','pricing','cost','rate','budget')) return `Pricing depends on media format, market, location, duration and campaign size. Share your city, format and duration through Enquire Now.<br>${link(L.enquire,'Start an Enquiry')}`;
   if(has('logo','brand','client','clients')) return `The website includes Krishna Outdoor brand information and an Our Esteemed Clients section.<br>${link(L.home,'Home')} · ${link(L.work,'Our Work')}`;
   if(has('thank','thanks','okay','ok','great')) return `You’re welcome! Ask me about any Krishna Outdoor page, media solution, campaign or contact detail.`;
   if(pageName.includes('transit')) return `You’re on the Transit Media page. I can answer questions about buses, trains, shelters, formats and campaign planning.<br>${link(L.transit,'Open Transit Media')}`;
   if(pageName.includes('digital')) return `You’re on the Digital Media page. I can answer questions about DOOH, digital billboards, screens and campaign planning.<br>${link(L.digital,'Open Digital Media')}`;
   if(pageName.includes('ooh')) return `You’re on the OOH Media page. I can answer questions about hoardings, billboards, locations and outdoor formats.<br>${link(L.ooh,'Open OOH Media')}`;
   if(pageName.includes('about')) return `You’re on the About page. Ask me about Krishna Outdoor’s journey, experience, leadership or media legacy.<br>${link(L.about,'Open About Us')}`;
   if(pageName.includes('project') || pageName.includes('work')) return `You’re on the Our Work page. Ask me about campaigns, projects, media formats or the work showcased here.<br>${link(L.work,'Open Our Work')} · ${link(L.campaign,'Open Campaign')}`;
   if(pageName.includes('network') || pageName.includes('location')) return `You’re on the Location / Our Network section. Ask me about market presence, cities, sites or media opportunities.<br>${link(L.location,'Open Location')} · ${link(L.network,'Open Our Network')}`;
   if(pageName.includes('career')) return `You’re on the Careers page. Ask me about career information or openings.<br>${link(L.careers,'Open Careers')}`;
   if(pageName.includes('contact') || pageName.includes('enquir')) return `You’re on the Enquire page. Here are the direct contact details:<br>${contactInfo()}`;
   return `I can help with the full Krishna Outdoor website. Ask me about Home, About, Media Solutions, OOH, Transit, Digital, Location, Our Network, Campaign, Our Work, Careers or Enquire Now.<br>${pageLinks()}`;
 };
 const reply=(input)=>{const thinking=showThinking();setTimeout(()=>{thinking.remove();addMessage(getReply(input),'bot',true)},900)};
 const closeChat=()=>{chatPanel.classList.remove('open');chatPanel.setAttribute('aria-hidden','true');chatPanel.inert=true;chatbot.setAttribute('aria-expanded','false')};
 const openChat=()=>{const wasOpen=chatPanel.classList.contains('open');chatPanel.classList.toggle('open');chatPanel.setAttribute('aria-hidden',wasOpen?'true':'false');chatPanel.inert=wasOpen;chatbot.setAttribute('aria-expanded',wasOpen?'false':'true');if(!wasOpen){if(!chatStartedAt) chatStartedAt=timeNow();setTimeout(()=>chatInput?.focus(),220)}scrollBottom()};
 chatbot.addEventListener('click',openChat);
 chatClose?.addEventListener('click',e=>{e.stopPropagation();closeChat()});
 document.addEventListener('keydown',e=>{if(e.key==='Escape') closeChat()});
 document.addEventListener('click',e=>{if(chatPanel.classList.contains('open')&&!e.target.closest('#chatPanel')&&!e.target.closest('#chatbot')) closeChat()});
 $$('[data-chat]').forEach(b=>b.addEventListener('click',()=>{const value=b.textContent.replace('↗','').trim();addMessage(value,'user');reply(value)}));
 chatComposer?.addEventListener('submit',e=>{e.preventDefault();const value=chatInput?.value.trim();if(!value)return;addMessage(value,'user');chatInput.value='';reply(value)});
 if(chatMessages && !chatMessages.querySelector('.chat-day')){const day=document.createElement('div');day.className='chat-day';day.textContent=`Today • ${timeNow()}`;chatMessages.prepend(day);$$('.msg-row.bot',chatMessages).forEach(row=>{if(!row.querySelector('.msg-avatar')) row.insertAdjacentHTML('afterbegin',avatar());let stack=row.querySelector('.msg-stack');if(!stack){const bubble=row.querySelector('.msg-bubble');stack=document.createElement('div');stack.className='msg-stack';if(bubble){bubble.parentNode.removeChild(bubble);stack.appendChild(bubble)}row.appendChild(stack)}})}
}
window.KO_CHAT_READY = true;
})();
