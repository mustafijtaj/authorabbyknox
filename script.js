/* Abby Knox — shared site interactions (every page) + home page widgets */
(() => {
  const $ = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---------- Mobile nav ---------- */
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

  /* ---------- Header shadow ---------- */
  const header = $(".site-header");
  const onScroll = () => header && header.classList.toggle("scrolled", window.scrollY > 10);
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  /* ---------- Reveal on scroll ---------- */
  const io = "IntersectionObserver" in window
    ? new IntersectionObserver((entries) => {
        entries.forEach((en) => { if (en.isIntersecting) { en.target.classList.add("in"); io.unobserve(en.target); } });
      }, { threshold: 0.08, rootMargin: "0px 0px -40px 0px" })
    : null;
  const observeReveals = () => $$(".reveal:not(.in)").forEach((el) => (io ? io.observe(el) : el.classList.add("in")));

  /* ---------- Newsletter forms (Mailchimp) ---------- */
  $$(".nl-form").forEach((form) => {
    const msg = $(".form-msg", form);
    form.addEventListener("submit", (e) => {
      const email = form.EMAIL.value.trim();
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        e.preventDefault();
        msg.textContent = "Please enter a valid email address.";
        form.EMAIL.focus();
        return;
      }
      msg.textContent = "Almost there — finish signing up in the new tab. ♥";
    });
  });

  /* ---------- Footer year ---------- */
  $$(".year").forEach((el) => (el.textContent = new Date().getFullYear()));

  /* ---------- Signed books filter ---------- */
  const shopChips = $$("[data-shop]");
  shopChips.forEach((chip) =>
    chip.addEventListener("click", () => {
      shopChips.forEach((c) => { c.classList.toggle("active", c === chip); c.setAttribute("aria-selected", String(c === chip)); });
      $$("#shopGrid .product").forEach((p) => {
        p.hidden = chip.dataset.shop !== "all" && p.dataset.cat !== chip.dataset.shop;
        p.classList.add("in");
      });
    })
  );

  /* ---------- Content notes: open/close all ---------- */
  const toggleAll = $("#toggleAll");
  if (toggleAll) {
    toggleAll.addEventListener("click", () => {
      const notes = $$(".note");
      const open = !notes.every((n) => n.open);
      notes.forEach((n) => (n.open = open));
      toggleAll.textContent = open ? "Hide all notes" : "Show all notes";
    });
  }

  /* =========================================================
     Home page widgets
     ========================================================= */
  const latestRow = $("#latestRow");
  if (latestRow) {
    const CDN = "https://images.squarespace-cdn.com/content/v1/59ca86e87131a59786c2e17f/";
    const B2R = "https://books2read.com/u/";
    const AMZ = "https://www.amazon.com/dp/";
    const books = [
      { t: "Unmoored", s: "How to Fail at Hating the Boss", img: "1787014352124-KC3EFAXMGMBIIRJT37XC/Unmoored_Final.jpg", url: B2R + "mqypvO", tags: ["latest", "un"] },
      { t: "Unplanned", s: "How I Cancelled my Wedding and Got My Happily Ever After", img: "1787014314292-8K4HU4E8AZACJM93UQAE/Unplanned_Final.jpg", url: B2R + "49EpVd", tags: ["latest", "un"] },
      { t: "Unsteady", s: "How to Fail at Flirting", img: "1787014336384-MXYSGGMZ4S5FW8HH7YEB/Unsteady_Final.jpg", url: B2R + "mVGlw2", tags: ["latest", "un"] },
      { t: "Undressed", s: "How I Fell for My One Night Stand", img: "1775138561873-UA4518BHI3XJATHM5LL0/Undressed_Final.jpg", url: AMZ + "B0GQR92PQT", tags: ["latest", "un"] },
      { t: "Unfinished", s: "How to Fail at Avoiding Your Ex", img: "1775138549647-RRSEK8DB2JT7BSDGMFON/Unfinished_Final.jpg", url: AMZ + "B0GDNS2G6Z", tags: ["latest", "un"] },
      { t: "Unmatchable", s: "How to Fail at Staying Single", img: "1775138537396-ZR2Q1FP6TD65NO4QCE9A/Unmatchable_Final.jpg", url: AMZ + "B0GDNPFXQ1", tags: ["latest", "un"] },
      { t: "Unruly", s: "How to Fail at Fake Dating", img: "1770037885025-3RN8DQY5AXIZWCZ78YRW/Unruly-Kindle.jpg", url: B2R + "4AWy70", tags: ["latest", "un"] },
      { t: "Sleighed by the Orc", s: "Christmas Elf Universe", img: "1765470070650-J9WGUZJ5Q3V8PY56W3IO/Sleighed_By_The_Orc_Final.jpg", url: AMZ + "B0G2T2BMQB", tags: ["latest", "holiday", "paranormal"] },
      { t: "Bingeworthy", s: "A Thanksgiving Romance", img: "1763571811421-SDGZCODXTOJTHBRJEG9J/Bingeworthy_Final.jpg", url: B2R + "3nRB5R", tags: ["latest", "holiday"] },
      { t: "Bound to Happen", s: "A workplace romance", img: "1761834630469-QD3LRBD21VS85G2EKIK2/BOUND.jpg", url: AMZ + "B0FTQXZ1CB", tags: ["latest", "holiday"] },
      { t: "Running to the Cowboy", s: "Runaway Brides & Heroes · Book 1", img: "1735844818652-9RJMELMPYNE175SPL5CM/1.jpg", url: B2R + "bPa1ll", tags: ["darling"] },
      { t: "Running to the Farmer", s: "Runaway Brides & Heroes · Book 2", img: "1735844964865-63R6ZRLRSNIVLURMM1NS/2.jpg", url: B2R + "3LXrlJ", tags: ["darling"] },
      { t: "Running to the Mountain Man", s: "Runaway Brides & Heroes · Book 3", img: "1735844833054-GO2RUYD7FGKP5OKSONFB/3.jpg", url: B2R + "mqOK89", tags: ["darling"] },
      { t: "Taken by the Bounty Hunter", s: "Runaway Brides & Heroes · Book 4", img: "1741276085455-ARVVTVNFXUVXGEZYORHY/Taken-by-the-Bounty-Hunter-Kindle.jpg", url: B2R + "4A0DDo", tags: ["darling"] },
      { t: "Stolen by the Hit Man", s: "Runaway Brides & Heroes · Book 5", img: "1761833899212-WEZC0L8GL7XX58QHZT5Z/Stolen-by-the-Hit-Man-Apple.jpg", url: B2R + "mYO1rV", tags: ["darling"] },
      { t: "Rescued by the Operative", s: "Runaway Brides & Heroes · Book 6", img: "1761833954287-VPKTK3E38S1RUKW9QZMV/Rescued_by_the_Operative_Final.jpg", url: B2R + "mBY8zv", tags: ["darling"] },
      { t: "Elf-napped", s: "Christmas Elf Universe", img: "1761835111507-N2KW2CWKLINE56B3VF0U/Elf-napped-Kindle.jpg", url: B2R + "bzVBOn", tags: ["holiday", "paranormal"] },
      { t: "Bagged by the Elf", s: "Christmas Elf Universe", img: "1702831335323-ET4356KL8PLNXRSP7U4C/Bagged_By_The_Elf_New_Final.jpg", url: B2R + "bOjang", tags: ["holiday", "paranormal"] },
      { t: "What the Elf", s: "Christmas Elf Universe", img: "1735845350859-1OI0KUH67Q6P13YPQBLQ/What-The-Elf-Apple.jpg", url: B2R + "4jOBpv", tags: ["holiday", "paranormal"] },
      { t: "Wish List", s: "Roadside Attractions", img: "1711661898525-54J14XNEP93PRTW54V2G/Wish-List-Generic.jpg", url: B2R + "3RzRZv", tags: ["holiday"] },
      { t: "Fate's Holi-Date", s: "Roadside Attractions", img: "1702831287033-F7H6J9PSH20R8JAEI2DY/Holi-date+of+Fate-v4.jpg", url: B2R + "bQgAOv", tags: ["holiday"] },
      { t: "A Guardian for Christmas", s: "Holiday stand-alone", img: "1735240011830-ZZPJP8PI57QSDZYOT8QK/guardian+for+christmas.jpg", url: AMZ + "B0DKTVY7YZ", tags: ["holiday"] },
      { t: "The Wood Family Christmas", s: "The Wood Brothers", img: "1702830988439-VD0QWSOW2HDQZ9GZX26V/AK_WoodFamilyChristmas_eBook.jpeg", url: B2R + "mZpXOJ", tags: ["holiday"] },
      { t: "Wishes, Snow, and Mistletoe", s: "Holiday romance", img: "1732236534259-HNOAU3Y6PFLUF7W6WDKV/Wishes+1.jpg", url: B2R + "bpka76", tags: ["holiday"] },
      { t: "Halloween Flip", s: "Birchdale Universe", img: "1761835297505-CN12FFPGQN8YWT1WOR7C/Halloween-Flip-Apple.jpg", url: B2R + "4Dn1YA", tags: ["holiday", "paranormal"] },
      { t: "A Date with Demons", s: "Birchdale Universe", img: "1729783984885-PQR832FPROAKS2NQVN3B/A_Date_With_Demons_Final.jpg", url: B2R + "38l0Za", tags: ["paranormal"] },
      { t: "The Witch's Werewolf", s: "Birchdale Universe", img: "1761835219000-G7N0BX1QDGDX9DINVXCF/The_Witchs_Warewolf_Final.jpg", url: B2R + "3RvYLj", tags: ["paranormal"] },
      { t: "He Falls First", s: "Fate Universe stand-alone", img: "1728568557643-BILDFXJE58NGCJZ9JHL8/he+falls+first.png", url: B2R + "mY2qQG", tags: [] },
      { t: "Essentially Autumn", s: "Cozy fall romance", img: "1728568506173-S7C0F1X55TJON651A4JI/Essentially_Autumn_Final.jpg", url: B2R + "mdanBW", tags: ["holiday"] },
      { t: "The Bodyguard & His Bunny", s: "Duets", img: "1711661620943-LZ1X63AHIOS799IVM3TI/The_Bodyguard_%26_His_Bunny_Final.jpg", url: B2R + "4ENw9g", tags: [] },
      { t: "Love That For Me", s: "Small-Town Gossip", img: "1711661752038-SCSJEEGSYP90AFAD8TF1/Love-That-For-Me-Generic.jpg", url: B2R + "bwy05a", tags: [] },
    ];

    const esc = (s) => s.replace(/[&<>"']/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]));
    const store = (u) => (u.includes("amazon") ? "Amazon" : "All stores");
    const card = (b, i, extra = "") => `
      <a class="book-card" href="${b.url}" target="_blank" rel="noopener" aria-label="${esc(b.t)}: ${esc(b.s)} — buy now" style="animation-delay:${Math.min(i, 12) * 35}ms">
        <div class="cover">
          <img src="${CDN}${b.img}?format=500w" alt="${esc(b.t)} book cover" loading="lazy" width="300" height="450" />
          <span class="buy">Buy now</span>
        </div>
        ${extra}
        <h3>${esc(b.t)}</h3>
        <p class="sub">${esc(b.s)}</p>
        <span class="store">${store(b.url)}</span>
      </a>`;

    latestRow.innerHTML = books.filter((b) => b.tags.includes("latest")).map((b, i) => card(b, i)).join("");
    const seriesGrid = $("#seriesGrid");
    if (seriesGrid) {
      seriesGrid.innerHTML = books.filter((b) => b.tags.includes("darling"))
        .map((b, i) => `<li class="reveal">${card(b, i, `<span class="num">Book ${i + 1}</span>`)}</li>`).join("");
    }

    // Library filter + search
    const grid = $("#bookGrid"), empty = $("#empty"), search = $("#search");
    let filter = "all";
    const renderLib = () => {
      const q = search.value.trim().toLowerCase();
      const list = books.filter((b) => (filter === "all" || b.tags.includes(filter)) && (!q || (b.t + " " + b.s).toLowerCase().includes(q)));
      grid.innerHTML = list.map((b, i) => card(b, i)).join("");
      empty.hidden = list.length > 0;
    };
    $$(".chip[data-filter]").forEach((chip) =>
      chip.addEventListener("click", () => {
        $$(".chip[data-filter]").forEach((c) => { c.classList.toggle("active", c === chip); c.setAttribute("aria-selected", String(c === chip)); });
        filter = chip.dataset.filter;
        renderLib();
      })
    );
    search.addEventListener("input", renderLib);
    renderLib();

    // Carousel arrows
    const prev = $(".car-btn.prev"), next = $(".car-btn.next");
    const updateCar = () => {
      prev.disabled = latestRow.scrollLeft < 8;
      next.disabled = latestRow.scrollLeft + latestRow.clientWidth >= latestRow.scrollWidth - 8;
    };
    [prev, next].forEach((btn) =>
      btn.addEventListener("click", () => latestRow.scrollBy({ left: latestRow.clientWidth * 0.8 * Number(btn.dataset.dir), behavior: reduceMotion ? "auto" : "smooth" }))
    );
    latestRow.addEventListener("scroll", updateCar, { passive: true });
    window.addEventListener("resize", updateCar);
    updateCar();

    // Count-up stat
    $$("[data-count]").forEach((el) => {
      const target = Number(el.dataset.count) || books.length;
      if (reduceMotion) { el.textContent = target; return; }
      let n = 0;
      const step = () => { n += 1; el.textContent = n; if (n < target) requestAnimationFrame(step); };
      setTimeout(step, 400);
    });
  }

  observeReveals();
})();
