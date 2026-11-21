/* Abby Knox theme — interactions */
(() => {
  const $ = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* Mobile nav */
  const toggle = $("#navToggle");
  const nav = $("#nav");
  if (toggle && nav) {
    const setNav = (open) => {
      nav.classList.toggle("open", open);
      toggle.setAttribute("aria-expanded", String(open));
      toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
      document.body.style.overflow = open ? "hidden" : "";
    };
    toggle.addEventListener("click", () => setNav(!nav.classList.contains("open")));
    $$("a", nav).forEach((a) => a.addEventListener("click", () => setNav(false)));
    document.addEventListener("keydown", (e) => { if (e.key === "Escape") setNav(false); });
    window.matchMedia("(min-width: 1181px)").addEventListener("change", (e) => e.matches && setNav(false));
  }

  /* Header shadow */
  const header = $(".site-header");
  const onScroll = () => header && header.classList.toggle("scrolled", window.scrollY > 10);
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  /* Reveal on scroll */
  const io = "IntersectionObserver" in window
    ? new IntersectionObserver((entries) => {
        entries.forEach((en) => { if (en.isIntersecting) { en.target.classList.add("in"); io.unobserve(en.target); } });
      }, { threshold: 0.08, rootMargin: "0px 0px -40px 0px" })
    : null;
  $$(".reveal").forEach((el) => (io ? io.observe(el) : el.classList.add("in")));

  /* Newsletter forms */
  $$(".nl-form").forEach((form) => {
    const msg = $(".form-msg", form);
    form.addEventListener("submit", (e) => {
      const email = form.EMAIL.value.trim();
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        e.preventDefault();
        if (msg) msg.textContent = "Please enter a valid email address.";
        form.EMAIL.focus();
        return;
      }
      if (msg) msg.textContent = "Almost there — finish signing up in the new tab. ♥";
    });
  });

  /* Book grid: filter chips + search (home library) */
  $$("[data-filter-for]").forEach((group) => {
    const grid = document.getElementById(group.dataset.filterFor);
    if (!grid) return;
    const search = $(`[data-search-for="${group.dataset.filterFor}"]`);
    const empty = document.getElementById(group.dataset.filterFor + "Empty");
    let filter = "all";
    const apply = () => {
      const q = search ? search.value.trim().toLowerCase() : "";
      let shown = 0;
      $$(".book-card", grid).forEach((card) => {
        const tags = (card.dataset.tags || "").split(" ");
        const hit = (filter === "all" || tags.includes(filter)) && (!q || (card.dataset.search || "").includes(q));
        card.hidden = !hit;
        if (hit) shown++;
      });
      if (empty) empty.hidden = shown > 0;
    };
    $$(".chip", group).forEach((chip) =>
      chip.addEventListener("click", () => {
        $$(".chip", group).forEach((c) => { c.classList.toggle("active", c === chip); c.setAttribute("aria-selected", String(c === chip)); });
        filter = chip.dataset.filter;
        apply();
      })
    );
    if (search) search.addEventListener("input", apply);
  });

  /* Carousel arrows */
  const row = $("#latestRow");
  if (row) {
    const prev = $(".car-btn.prev"), next = $(".car-btn.next");
    const update = () => {
      prev.disabled = row.scrollLeft < 8;
      next.disabled = row.scrollLeft + row.clientWidth >= row.scrollWidth - 8;
    };
    [prev, next].forEach((btn) =>
      btn.addEventListener("click", () => row.scrollBy({ left: row.clientWidth * 0.8 * Number(btn.dataset.dir), behavior: reduceMotion ? "auto" : "smooth" }))
    );
    row.addEventListener("scroll", update, { passive: true });
    window.addEventListener("resize", update);
    update();
  }

  /* Count-up */
  $$("[data-count]").forEach((el) => {
    const target = Number(el.dataset.count) || 0;
    if (reduceMotion || !target) { el.textContent = target; return; }
    let n = 0;
    const step = Math.max(1, Math.round(target / 40));
    el.textContent = "0";
    const tick = () => { n = Math.min(target, n + step); el.textContent = n; if (n < target) requestAnimationFrame(tick); };
    setTimeout(tick, 400);
  });

  /* Reading list search */
  const rlSearch = $("#rlSearch");
  if (rlSearch) {
    const list = $("#rlList"), empty = $("#rlEmpty"), jump = $("#rlJump");
    rlSearch.addEventListener("input", () => {
      const q = rlSearch.value.trim().toLowerCase();
      let shown = 0;
      $$("[data-universe]", list).forEach((u) => {
        let uCount = 0;
        $$("[data-series]", u).forEach((s) => {
          const sName = $("h3", s).textContent.toLowerCase();
          let sCount = 0;
          $$("li", s).forEach((li) => {
            const hit = !q || li.dataset.title.includes(q) || sName.includes(q);
            li.hidden = !hit;
            if (hit) sCount++;
          });
          s.hidden = sCount === 0;
          uCount += sCount;
        });
        u.hidden = uCount === 0;
        u.classList.add("in");
        shown += uCount;
      });
      if (empty) empty.hidden = shown > 0;
      if (jump) jump.hidden = !!q;
    });
  }

  /* Content notes: open/close all */
  const toggleAll = $("#toggleAll");
  if (toggleAll) {
    toggleAll.addEventListener("click", () => {
      const notes = $$(".note");
      const open = !notes.every((n) => n.open);
      notes.forEach((n) => (n.open = open));
      toggleAll.textContent = open ? "Hide all notes" : "Show all notes";
    });
  }
})();
