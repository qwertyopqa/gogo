(function() {
  window.wrapperClick = (el) => {
    const a = el.querySelector('&> h2 > a');
    if (a) a.click();
  }
  const root = document.querySelector(':root');
  let is_hp = false;
  window.onscroll = () => {
    root.style.setProperty('--scroll-y', window.scrollY);
    updateBannerFact();
  };

  function updateBannerFact() {
    if (is_hp) {
      const h = window.scrollY / (root.clientHeight - 100);
      root.style.setProperty('--banner-fact', h > 1 ? 1 : h * h);
    }
  }

  function buildHpTeaserThing() {
    function buildSection(where, text, parent) {
      const el = document.createElement('div');
      el.classList.add(`banner__${where}`);
      el.innerHTML = `<span>${text}</span>`;
      parent.appendChild(el);
    }
    const bs = root.getElementsByTagName('header');
    if (bs.length) {
      const db = ['Wake|Me Up', 'Like A|Yo-Yo', 'lorem|ipsum'];
      const e = db[Math.floor(Math.random() * db.length)].split('|');
      buildSection('top', e[0], bs[0]);
      buildSection('bot', e[1], bs[0]);
      updateBannerFact();
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    if (root.classList.contains('node-hp')) {
      is_hp = true;
      buildHpTeaserThing();
    }
    if (root.classList.contains('node-listing_page')) {
      const tag = getCookie('tag');
      if (tag !== '') {
        const tags = document.querySelectorAll(`input[name="tags[${tag}]"`);
        if (tags.length) {
          tags[0].click();
        }
      }
    }
  });

  function setCookie(cname, cvalue, exp_secs) {
    const d = new Date();
    d.setTime(d.getTime() + (exp_secs*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  window.tagClick = (id) => {
    setCookie('tag', id, 5);
    window.location.href = '/articles';
  }
})();
