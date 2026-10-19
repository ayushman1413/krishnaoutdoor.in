/* Krishna Outdoor - toast + lightbox for Laravel pages (no dependencies) */
(function () {
  window.krToast = function (status, title, text) {
    var t = document.createElement('div');
    t.className = 'kr-toast' + (status === 'error' ? ' error' : '');
    t.setAttribute('role', 'status');
    var b = document.createElement('b'); b.textContent = title || '';
    var s = document.createElement('span'); s.textContent = text || '';
    t.appendChild(b); t.appendChild(s); document.body.appendChild(t);
    requestAnimationFrame(function () { t.classList.add('show'); });
    setTimeout(function () { t.classList.remove('show'); setTimeout(function () { t.remove(); }, 400); }, 6000);
  };

  var links = [], idx = 0, lb;
  function build() {
    lb = document.createElement('div'); lb.className = 'kr-lb';
    lb.innerHTML = '<button class="x" aria-label="Close">&times;</button><button class="p" aria-label="Previous">&#8249;</button><img alt=""><button class="n" aria-label="Next">&#8250;</button>';
    document.body.appendChild(lb);
    lb.addEventListener('click', function (e) {
      if (e.target === lb || e.target.classList.contains('x')) close();
      else if (e.target.classList.contains('p')) show(idx - 1);
      else if (e.target.classList.contains('n')) show(idx + 1);
    });
    document.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('open')) return;
      if (e.key === 'Escape') close(); if (e.key === 'ArrowLeft') show(idx - 1); if (e.key === 'ArrowRight') show(idx + 1);
    });
  }
  function show(i) { idx = (i + links.length) % links.length; lb.querySelector('img').src = links[idx].href; lb.querySelector('.p').style.display = lb.querySelector('.n').style.display = links.length > 1 ? '' : 'none'; }
  function close() { lb.classList.remove('open'); }
  document.addEventListener('click', function (e) {
    var a = e.target.closest('a.kr-lightbox'); if (!a) return;
    e.preventDefault(); if (!lb) build();
    var g = a.getAttribute('data-group');
    links = [].slice.call(document.querySelectorAll('a.kr-lightbox' + (g ? '[data-group="' + g + '"]' : '')));
    lb.classList.add('open'); show(links.indexOf(a));
  });
})();


/* "Enquire Now" is rendered once: in the header bar on desktop, moved into the
   menu drawer on phones (<= 760px), so only one copy exists per viewport. */
(function () {
  var btn = document.querySelector('.header .nav-cta.enquiry-popup-trigger, .header .nav-cta-drawer.enquiry-popup-trigger');
  var box = document.querySelector('.header .nav-cta-drawer-box');
  if (!btn || !box || !window.matchMedia) { return; }
  var home = btn.parentNode, anchor = btn.nextSibling;
  var mq = window.matchMedia('(max-width: 760px)');
  function place() {
    if (mq.matches) {
      btn.classList.remove('nav-cta'); btn.classList.add('nav-cta-drawer'); box.appendChild(btn);
    } else {
      btn.classList.remove('nav-cta-drawer'); btn.classList.add('nav-cta'); home.insertBefore(btn, anchor && anchor.parentNode === home ? anchor : null);
    }
  }
  place();
  if (mq.addEventListener) { mq.addEventListener('change', place); } else { mq.addListener(place); }
})();


/* Lazy CSRF token: pages carry no per-request token, so forms ask for one the
   first time they are used (focus) or, at the latest, when they are submitted. */
(function () {
  var pending;
  function token() {
    if (!pending) {
      pending = fetch('/csrf-token', { credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (j) { return j.token; })
        .catch(function (e) { pending = null; throw e; });
    }
    return pending;
  }
  function empty(form) {
    var field = form.querySelector('input[data-lazy-csrf]');
    return field && !field.value ? field : null;
  }
  function fill(form) {
    var field = empty(form);
    return field ? token().then(function (t) { field.value = t; }) : Promise.resolve();
  }
  document.addEventListener('focusin', function (e) {
    var form = e.target.closest && e.target.closest('form');
    if (form) { fill(form).catch(function () {}); }
  }, true);
  document.addEventListener('submit', function (e) {
    var form = e.target;
    if (!empty(form)) { return; }
    e.preventDefault();
    e.stopImmediatePropagation();
    fill(form).then(function () {
      if (form.requestSubmit) { form.requestSubmit(e.submitter || undefined); } else { form.submit(); }
    }).catch(function () { form.submit(); });
  }, true);
})();
