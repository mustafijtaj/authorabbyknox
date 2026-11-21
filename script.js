/* Abby Knox — site interactions */
(() => {
  const CDN = "https://images.squarespace-cdn.com/content/v1/59ca86e87131a59786c2e17f/";
  const B2R = "https://books2read.com/u/";
  const AMZ = "https://www.amazon.com/dp/";

  // tags: un (How to Fail series), latest, darling, holiday, paranormal
  const books = [
    // Latest releases
    { t: "Unmoored", s: "How to Fail at Hating the Boss", img: "1787014352124-KC3EFAXMGMBIIRJT37XC/Unmoored_Final.jpg", url: B2R + "mqypvO", tags: ["latest", "un"] },
    { t: "Unplanned", s: "How I Cancelled my Wedding and Got My Happily Ever After", img: "1787014314292-8K4HU4E8AZACJM93UQAE/Unplanned_Final.jpg", url: B2R + "49EpVd", tags: ["latest", "un"] },
    { t: "Unsteady", s: "How to Fail at Flirting", img: "1787014336384-MXYSGGMZ4S5FW8HH7YEB/Unsteady_Final.jpg", url: B2R + "mVGlw2", tags: ["latest", "un"] },
    { t: "Undressed", s: "How I Fell for My One Night Stand", img: "1775138561873-UA4518BHI3XJATHM5LL0/Undressed_Final.jpg", url: AMZ + "B0GQR92PQT", tags: ["latest", "un"] },
    { t: "Unfinished", s: "How to Fail at Avoiding Your Ex", img: "1775138549647-RRSEK8DB2JT7BSDGMFON/Unfinished_Final.jpg", url: AMZ + "B0GDNS2G6Z", tags: ["latest", "un"] },
    { t: "Unmatchable", s: "How to Fail at Staying Single", img: "1775138537396-ZR2Q1FP6TD65NO4QCE9A/Unmatchable_Final.jpg", url: AMZ + "B0GDNPFXQ1", tags: ["latest", "un"] },
    { t: "Unruly", s: "How to Fail at Fake Dating", img: "1770037885025-3RN8DQY5AXIZWCZ78YRW/Unruly-Kindle.jpg", url: B2R + "4AWy70", tags: ["latest", "un"] },
    { t: "Sleighed by the Orc", s: "A monster holiday romance", img: "1765470070650-J9WGUZJ5Q3V8PY56W3IO/Sleighed_By_The_Orc_Final.jpg", url: AMZ + "B0G2T2BMQB", tags: ["latest", "holiday", "paranormal"] },
    { t: "Bingeworthy", s: "A Thanksgiving Romance", img: "1763571811421-SDGZCODXTOJTHBRJEG9J/Bingeworthy_Final.jpg", url: B2R + "3nRB5R", tags: ["latest", "holiday"] },
    { t: "Bound to Happen", s: "A workplace romance", img: "1761834630469-QD3LRBD21VS85G2EKIK2/BOUND.jpg", url: AMZ + "B0FTQXZ1CB", tags: ["latest"] },

    // Darling Creek — Runaway Brides and Heroes
    { t: "Running to the Cowboy", s: "Runaway Brides & Heroes · Book 1", img: "1735844818652-9RJMELMPYNE175SPL5CM/1.jpg", url: B2R + "bPa1ll", tags: ["darling"] },
    { t: "Running to the Farmer", s: "Runaway Brides & Heroes · Book 2", img: "1735844964865-63R6ZRLRSNIVLURMM1NS/2.jpg", url: B2R + "3LXrlJ", tags: ["darling"] },
    { t: "Running to the Mountain Man", s: "Runaway Brides & Heroes · Book 3", img: "1735844833054-GO2RUYD7FGKP5OKSONFB/3.jpg", url: B2R + "mqOK89", tags: ["darling"] },
    { t: "Taken by the Bounty Hunter", s: "Runaway Brides & Heroes · Book 4", img: "1741276085455-ARVVTVNFXUVXGEZYORHY/Taken-by-the-Bounty-Hunter-Kindle.jpg", url: B2R + "4A0DDo", tags: ["darling"] },
    { t: "Stolen by the Hit Man", s: "Runaway Brides & Heroes · Book 5", img: "1761833899212-WEZC0L8GL7XX58QHZT5Z/Stolen-by-the-Hit-Man-Apple.jpg", url: B2R + "mYO1rV", tags: ["darling"] },
    { t: "Rescued by the Operative", s: "Runaway Brides & Heroes · Book 6", img: "1761833954287-VPKTK3E38S1RUKW9QZMV/Rescued_by_the_Operative_Final.jpg", url: B2R + "mBY8zv", tags: ["darling"] },

    // More by Abby Knox
    { t: "Elf Napped", s: "Holiday paranormal romance", img: "1761835111507-N2KW2CWKLINE56B3VF0U/Elf-napped-Kindle.jpg", url: B2R + "bzVBOn", tags: ["holiday", "paranormal"] },
    { t: "Bagged by the Elf", s: "Holiday paranormal romance", img: "1702831335323-ET4356KL8PLNXRSP7U4C/Bagged_By_The_Elf_New_Final.jpg", url: B2R + "bOjang", tags: ["holiday", "paranormal"] },
    { t: "What the Elf", s: "Holiday paranormal romance", img: "1735845350859-1OI0KUH67Q6P13YPQBLQ/What-The-Elf-Apple.jpg", url: B2R + "4jOBpv", tags: ["holiday", "paranormal"] },
    { t: "Wish List", s: "Holiday romance", img: "1711661898525-54J14XNEP93PRTW54V2G/Wish-List-Generic.jpg", url: B2R + "3RzRZv", tags: ["holiday"] },
    { t: "Holi-date of Fate", s: "Holiday romance", img: "1702831287033-F7H6J9PSH20R8JAEI2DY/Holi-date+of+Fate-v4.jpg", url: B2R + "bQgAOv", tags: ["holiday"] },
    { t: "A Guardian for Christmas", s: "Holiday romance", img: "1735240011830-ZZPJP8PI57QSDZYOT8QK/guardian+for+christmas.jpg", url: AMZ + "B0DKTVY7YZ", tags: ["holiday"] },
    { t: "A Wood Family Christmas", s: "Holiday romance", img: "1702830988439-VD0QWSOW2HDQZ9GZX26V/AK_WoodFamilyChristmas_eBook.jpeg", url: B2R + "mZpXOJ", tags: ["holiday"] },
    { t: "Wishes, Snow, and Mistletoe", s: "Holiday romance", img: "1732236534259-HNOAU3Y6PFLUF7W6WDKV/Wishes+1.jpg", url: B2R + "bpka76", tags: ["holiday"] },
    { t: "Halloween Flip", s: "Spooky-season romance", img: "1761835297505-CN12FFPGQN8YWT1WOR7C/Halloween-Flip-Apple.jpg", url: B2R + "4Dn1YA", tags: ["holiday"] },
    { t: "A Date with Demons", s: "Paranormal romance", img: "1729783984885-PQR832FPROAKS2NQVN3B/A_Date_With_Demons_Final.jpg", url: B2R + "38l0Za", tags: ["paranormal"] },
    { t: "The Witch's Werewolf", s: "Paranormal romance", img: "1761835219000-G7N0BX1QDGDX9DINVXCF/The_Witchs_Warewolf_Final.jpg", url: B2R + "3RvYLj", tags: ["paranormal"] },
    { t: "He Falls First", s: "Contemporary romance", img: "1728568557643-BILDFXJE58NGCJZ9JHL8/he+falls+first.png", url: B2R + "mY2qQG", tags: [] },
    { t: "Essentially Autumn", s: "Cozy fall romance", img: "1728568506173-S7C0F1X55TJON651A4JI/Essentially_Autumn_Final.jpg", url: B2R + "mdanBW", tags: ["holiday"] },
    { t: "The Bodyguard & His Bunny", s: "Protector romance", img: "1711661620943-LZ1X63AHIOS799IVM3TI/The_Bodyguard_%26_His_Bunny_Final.jpg", url: B2R + "4ENw9g", tags: [] },
    { t: "Love That For Me", s: "Contemporary romance", img: "1711661752038-SCSJEEGSYP90AFAD8TF1/Love-That-For-Me-Generic.jpg", url: B2R + "bwy05a", tags: [] },
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

  // Latest carousel
  const latestRow = document.getElementById("latestRow");
  latestRow.innerHTML = books.filter((b) => b.tags.includes("latest")).map((b, i) => card(b, i)).join("");

  // Darling Creek series
  document.getElementById("seriesGrid").innerHTML = books
    .filter((b) => b.tags.includes("darling"))
    .map((b, i) => `<li class="reveal">${card(b, i, `<span class="num">Book ${i + 1}</span>`)}</li>`)
    .join("");

  // Library with filters + search
  const grid = document.getElementById("bookGrid");
  const empty = document.getElementById("empty");
  const search = document.getElementById("search");
  let filter = "all";
  const renderLib = () => {
    const q = search.value.trim().toLowerCase();
    const list = books.filter((b) =>
      (filter === "all" || b.tags.includes(filter)) &&
      (!q || (b.t + " " + b.s).toLowerCase().includes(q))
    );
    grid.innerHTML = list.map((b, i) => card(b, i)).join("");
    empty.hidden = list.length > 0;
  };
  document.querySelectorAll(".chip").forEach((chip) =>
    chip.addEventListener("click", () => {
      document.querySelectorAll(".chip").forEach((c) => { c.classList.remove("active"); c.setAttribute("aria-selected", "false"); });
      chip.classList.add("active");
      chip.setAttribute("aria-selected", "true");
      filter = chip.dataset.filter;
      renderLib();
    })
  );
  search.addEventListener("input", renderLib);
  renderLib();

  // Carousel buttons
  const prev = document.querySelector(".car-btn.prev");
  const next = document.querySelector(".car-btn.next");
  const updateCar = () => {
    prev.disabled = latestRow.scrollLeft < 8;
    next.disabled = latestRow.scrollLeft + latestRow.clientWidth >= latestRow.scrollWidth - 8;
  };
  [prev, next].forEach((btn) =>
    btn.addEventListener("click", () => latestRow.scrollBy({ left: latestRow.clientWidth * 0.8 * Number(btn.dataset.dir), behavior: "smooth" }))
  );
  latestRow.addEventListener("scroll", updateCar, { passive: true });
  window.addEventListener("resize", updateCar);
  updateCar();

  // Mobile nav
  const toggle = document.getElementById("navToggle");
  const nav = document.getElementById("nav");
  const setNav = (open) => {
    nav.classList.toggle("open", open);
    toggle.setAttribute("aria-expanded", String(open));
    toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    document.body.style.overflow = open ? "hidden" : "";
  };
  toggle.addEventListener("click", () => setNav(!nav.classList.contains("open")));
  nav.querySelectorAll("a").forEach((a) => a.addEventListener("click", () => setNav(false)));
  document.addEventListener("keydown", (e) => { if (e.key === "Escape") setNav(false); });
  window.matchMedia("(min-width: 961px)").addEventListener("change", (e) => e.matches && setNav(false));

  // Header shadow + active section link
  const header = document.querySelector(".site-header");
  const onScroll = () => header.classList.toggle("scrolled", window.scrollY > 10);
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  const links = [...document.querySelectorAll('.nav ul a[href^="#"]')];
  const spy = new IntersectionObserver((entries) => {
    entries.forEach((en) => {
      if (en.isIntersecting) links.forEach((l) => l.classList.toggle("active", l.getAttribute("href") === "#" + en.target.id));
    });
  }, { rootMargin: "-45% 0px -50% 0px" });
  links.forEach((l) => { const s = document.querySelector(l.getAttribute("href")); s && spy.observe(s); });

  // Reveal on scroll
  const io = new IntersectionObserver((entries) => {
    entries.forEach((en) => { if (en.isIntersecting) { en.target.classList.add("in"); io.unobserve(en.target); } });
  }, { threshold: 0.12 });
  document.querySelectorAll(".reveal").forEach((el) => io.observe(el));

  // Count-up stat
  document.querySelectorAll("[data-count]").forEach((el) => {
    const target = books.length;
    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (reduce) { el.textContent = target; return; }
    let n = 0;
    const step = () => { n += 1; el.textContent = n; if (n < target) requestAnimationFrame(step); };
    setTimeout(step, 400);
  });

  // Newsletter: validate, then open Mailchimp signup with the email prefilled
  const form = document.getElementById("nlForm");
  const msg = document.getElementById("nlMsg");
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

  document.getElementById("year").textContent = new Date().getFullYear();
})();
