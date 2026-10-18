/*
 * GA4 click events (sent through window.koTrack, see layouts/app):
 *   click_call      tel: links
 *   click_email     mailto: links
 *   click_whatsapp  wa.me / api.whatsapp.com links
 *   chat_start      first time the Krishna AI chat is opened on a page
 * Lead form submissions (generate_lead) are fired server-side after a
 * successful submit, via the session flash in the layout.
 */
(function () {
  'use strict';

  function track(name, params) {
    if (typeof window.koTrack === 'function') {
      window.koTrack(name, params);
    }
  }

  document.addEventListener('click', function (event) {
    var link = event.target.closest && event.target.closest('a[href]');
    if (!link) {
      return;
    }
    var href = link.getAttribute('href') || '';
    var params = { link_url: href, link_text: (link.textContent || '').trim().slice(0, 100) };

    if (href.indexOf('tel:') === 0) {
      track('click_call', params);
    } else if (href.indexOf('mailto:') === 0) {
      track('click_email', params);
    } else if (/^https?:\/\/(wa\.me|api\.whatsapp\.com|web\.whatsapp\.com)\//.test(href)) {
      track('click_whatsapp', params);
    }
  }, true);

  var chatStarted = false;
  document.addEventListener('click', function (event) {
    if (chatStarted || !event.target.closest || !event.target.closest('#chatbot')) {
      return;
    }
    chatStarted = true;
    track('chat_start', { widget: 'krishna_ai' });
  }, true);
})();
