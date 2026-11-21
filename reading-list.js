/* Complete reading list — data + rendering */
(() => {
  const CDN = "https://images.squarespace-cdn.com/content/v1/59ca86e87131a59786c2e17f/";
  const B2R = "https://books2read.com/u/";
  const AMZ = "https://www.amazon.com/dp/";
  const ALSO = (asin) => `https://alsoby.me/r/amazon/${asin}?fc=us&ds=1`;

  // Titles with a known store link (and cover where available)
  const known = {
    "Unmoored": { url: B2R + "mqypvO", img: "1787014352124-KC3EFAXMGMBIIRJT37XC/Unmoored_Final.jpg" },
    "Unplanned": { url: B2R + "49EpVd", img: "1787014314292-8K4HU4E8AZACJM93UQAE/Unplanned_Final.jpg" },
    "Unsteady": { url: B2R + "mVGlw2", img: "1787014336384-MXYSGGMZ4S5FW8HH7YEB/Unsteady_Final.jpg" },
    "Undressed": { url: AMZ + "B0GQR92PQT", img: "1775138561873-UA4518BHI3XJATHM5LL0/Undressed_Final.jpg" },
    "Unruly": { url: B2R + "4AWy70", img: "1770037885025-3RN8DQY5AXIZWCZ78YRW/Unruly-Kindle.jpg" },
    "Unmatchable": { url: AMZ + "B0GDNPFXQ1", img: "1775138537396-ZR2Q1FP6TD65NO4QCE9A/Unmatchable_Final.jpg" },
    "Unfinished": { url: AMZ + "B0GDNS2G6Z", img: "1775138549647-RRSEK8DB2JT7BSDGMFON/Unfinished_Final.jpg" },
    "Running to the Cowboy": { url: B2R + "bPa1ll", img: "1735844818652-9RJMELMPYNE175SPL5CM/1.jpg" },
    "Running to the Farmer": { url: B2R + "3LXrlJ", img: "1735844964865-63R6ZRLRSNIVLURMM1NS/2.jpg" },
    "Running to the Mountain Man": { url: B2R + "mqOK89", img: "1735844833054-GO2RUYD7FGKP5OKSONFB/3.jpg" },
    "Taken by the Bounty Hunter": { url: B2R + "4A0DDo", img: "1741276085455-ARVVTVNFXUVXGEZYORHY/Taken-by-the-Bounty-Hunter-Kindle.jpg" },
    "Stolen by the Hit Man": { url: B2R + "mYO1rV", img: "1761833899212-WEZC0L8GL7XX58QHZT5Z/Stolen-by-the-Hit-Man-Apple.jpg" },
    "Rescued by the Operative": { url: B2R + "mBY8zv", img: "1761833954287-VPKTK3E38S1RUKW9QZMV/Rescued_by_the_Operative_Final.jpg" },
    "Love That For Me": { url: B2R + "bwy05a", img: "1711661752038-SCSJEEGSYP90AFAD8TF1/Love-That-For-Me-Generic.jpg" },
    "Wish List": { url: B2R + "3RzRZv", img: "1711661898525-54J14XNEP93PRTW54V2G/Wish-List-Generic.jpg" },
    "Fate's Holi-Date": { url: B2R + "bQgAOv", img: "1702831287033-F7H6J9PSH20R8JAEI2DY/Holi-date+of+Fate-v4.jpg" },
    "The Wood Family Christmas": { url: B2R + "mZpXOJ", img: "1702830988439-VD0QWSOW2HDQZ9GZX26V/AK_WoodFamilyChristmas_eBook.jpeg" },
    "He Falls First": { url: B2R + "mY2qQG", img: "1728568557643-BILDFXJE58NGCJZ9JHL8/he+falls+first.png" },
    "A Guardian for Christmas": { url: "https://www.amazon.com/dp/B0DKTVY7YZ", img: "1735240011830-ZZPJP8PI57QSDZYOT8QK/guardian+for+christmas.jpg" },
    "Halloween Flip": { url: B2R + "4Dn1YA", img: "1761835297505-CN12FFPGQN8YWT1WOR7C/Halloween-Flip-Apple.jpg" },
    "A Date with Demons": { url: B2R + "38l0Za", img: "1729783984885-PQR832FPROAKS2NQVN3B/A_Date_With_Demons_Final.jpg" },
    "The Witch's Werewolf": { url: B2R + "3RvYLj", img: "1761835219000-G7N0BX1QDGDX9DINVXCF/The_Witchs_Warewolf_Final.jpg" },
    "Elf-napped": { url: B2R + "bzVBOn", img: "1761835111507-N2KW2CWKLINE56B3VF0U/Elf-napped-Kindle.jpg" },
    "Bagged by the Elf": { url: B2R + "bOjang", img: "1702831335323-ET4356KL8PLNXRSP7U4C/Bagged_By_The_Elf_New_Final.jpg" },
    "What the Elf": { url: B2R + "4jOBpv", img: "1735845350859-1OI0KUH67Q6P13YPQBLQ/What-The-Elf-Apple.jpg" },
    "Sleighed by the Orc": { url: AMZ + "B0G2T2BMQB", img: "1765470070650-J9WGUZJ5Q3V8PY56W3IO/Sleighed_By_The_Orc_Final.jpg" },
    "Bingeworthy": { url: B2R + "3nRB5R", img: "1763571811421-SDGZCODXTOJTHBRJEG9J/Bingeworthy_Final.jpg" },
    "Bound to Happen": { url: AMZ + "B0FTQXZ1CB", img: "1761834630469-QD3LRBD21VS85G2EKIK2/BOUND.jpg" },
    "The Bodyguard and his Bunny": { url: B2R + "4ENw9g", img: "1711661620943-LZ1X63AHIOS799IVM3TI/The_Bodyguard_%26_His_Bunny_Final.jpg" },
    "Take Me Home": { url: ALSO("B076DK3KX5") },
    "Game Face": { url: ALSO("B077TRHPLR") },
    "Written in the Stars": { url: ALSO("B078HM432D") },
    "Walk With Me": { url: ALSO("B07DLL61Y3") },
    "Stay the Night": { url: ALSO("B07JF2PGJJ") },
    "Come and Get It": { url: ALSO("B07TWHC6HC") },
    "Pumpkin and Spice": { url: ALSO("B07KRRXT8B") },
    "Comfort and Joy": { url: ALSO("B07LC1LZ4H") },
    "Made for Marriage": { url: ALSO("B08BWSG7P8") },
    "Doctor Dave": { url: ALSO("B0828355WQ") },
    "Officer Max": { url: ALSO("B089CHTCGK") },
    "Saved for Me": { url: ALSO("B07M5HWK7T") },
    "Matched for Me": { url: ALSO("B07NPSCT1N") },
    "His Vinyl Vixen": { url: ALSO("B07FNQJ533") },
    "Her Hi-Fi Hunk": { url: ALSO("B07STJGVWL") },
    "Fencing Her In": { url: ALSO("B07V3TXFPL") },
    "Doing Him Good": { url: ALSO("B081V1T4R4") },
    "Butter Queen": { url: ALSO("B08J4946R6") },
    "Pumpkin King": { url: "https://www.amazon.com/gp/product/B08L618MQ7" },
  };

  // Universe → series → titles (reading order)
  const universes = [
    { id: "new-releases", name: "Newest Releases", desc: "Fresh off the press — the latest “How to Fail” rom-coms.", series: [
      { name: "The “How to Fail” collection", books: ["Unmoored", "Unplanned", "Unsteady", "Undressed"] },
    ]},
    { id: "songbird-ridge", name: "Songbird Ridge", series: [
      { name: "Songbird Ridge", books: ["Songbird Ridge: A Year in the Life", "Unruly", "Unmatchable", "Unfinished"] },
    ]},
    { id: "darling-creek", name: "Darling Creek Universe", desc: "Contemporary cowboy, western and small-town romance.", series: [
      { name: "The Mail-Order Brides of Darling Creek", note: "Contemporary cowboy/western", books: ["A Baby for the Bride", "A Week to Wed", "Her Guardian Groom"] },
      { name: "The Cowboy Bachelor Auction of Darling Creek", note: "Contemporary cowboy/western", books: ["The Cowgirl's Bid", "Winning the Cowboy", "Her Forbidden Prize"] },
      { name: "Small-Town Gossip", note: "Small-town romance set in Darling Creek", books: ["Do That To Me", "Say That To Me", "Love That For Me"] },
      { name: "The Runaway Brides of Darling Creek", note: "What happens when a cult comes to town", books: ["Running to the Cowboy", "Running to the Farmer", "Running to the Mountain Man"] },
      { name: "The Heroes of Darling Creek", note: "The town decides to take down the cult", books: ["Taken by the Bounty Hunter", "Stolen by the Hit Man", "Rescued by the Operative"] },
      { name: "Related stand-alone", books: ["Married in Misty Mountain"] },
    ]},
    { id: "fate", name: "Fate Universe", series: [
      { name: "Roadside Attractions", books: ["Roadside Attraction", "Claiming Fate", "Falling into Fate", "Fate's Dark Shadows", "Rode Hard", "Crash Into Me", "Snowed Under", "Wish List", "Fate's Holi-Date"] },
      { name: "Related to Roadside Attractions", note: "Crossover characters and locations", books: ["Accidentally Inn Love", "Next to You", "Foreign Exchange"] },
      { name: "The Wood Brothers", books: ["Nailed", "Screwed", "Drilled", "The Wood Family Christmas"] },
      { name: "Love Games", books: ["Roll for Initiative", "Roll for Damage", "Roll for Charisma"] },
      { name: "Related stand-alone", note: "Contains an easter egg for The Christmas Pickup", books: ["Hot off the Press"] },
      { name: "Little Spoon", books: ["Too Sweet", "Too Delicious"] },
      { name: "Crossover stand-alones", note: "Characters from Little Spoon and Fate", books: ["Fix Her Up", "Followed by the CEO", "He Falls First", "A Guardian for Christmas"] },
    ]},
    { id: "reckless-royals", name: "Reckless Royals", series: [
      { name: "Reckless Royals", books: ["Favored Prince", "Bad Prince", "Wild Prince", "Forgotten Prince", "Stolen Crown"] },
      { name: "Related stand-alone", books: ["Reckless in Ruins"] },
    ]},
    { id: "paradise-passions", name: "Paradise Passions", series: [
      { name: "Paradise Passions", books: ["Babymoon", "Honeymoon Hideout"] },
      { name: "Related stand-alones", note: "Crossover characters and/or locations", books: ["V-Card Vacation", "Are You For Reel", "Off-Season Stud", "Midsummer Fling", "Filthy Chef", "Hail Mary"] },
    ]},
    { id: "birchdale", name: "Birchdale Universe", desc: "Paranormal romance with witches, vampires and demons.", series: [
      { name: "Birchdale", books: ["Some Basic Witch", "Witch, Please", "Halloween Flip", "A Date with Demons", "The Witch's Werewolf"] },
    ]},
    { id: "christmas-elf", name: "Christmas Elf Universe", desc: "Paranormal holiday romance with rogue elves and friends.", series: [
      { name: "Christmas Elves", books: ["Elf-napped", "Bagged by the Elf", "What the Elf", "Sleighed by the Orc"] },
    ]},
    { id: "holiday", name: "Holiday Stand-alones", series: [
      { name: "Holiday Stand-alones", books: ["The Christmas Pickup", "Snow Plowed", "The Halloween Bet", "Bingeworthy", "Bound to Happen"] },
    ]},
    { id: "more-series", name: "More Series", series: [
      { name: "Beta Beta Psi", books: ["Big Bad Love", "Big Bad Girl", "Big Bad Tease", "Herc"] },
      { name: "The Crow Bar Brute Squad", books: ["Party Foul", "Dirty Martini", "Whiskey Sour"] },
      { name: "Sons of Earth and Heaven", note: "Paranormal fallen angel romance", books: ["Nephilim's Captive", "Nephilim's Beloved"] },
      { name: "Naughty Yachties", books: ["Shipped", "Secret Baby on Board", "Wrecked", "Decked", "Roped"] },
      { name: "Homemade Heat", books: ["Judge Me", "Cake Walk", "Hand-Tossed", "Chef's Kiss", "Bite Me"] },
      { name: "Big Easy Shifters", books: ["Taking the Belle", "Having His Cake", "Chasing the Night", "Running with the Pack", "Her Big Easy Shifter"] },
      { name: "The Greenbridge Academy", books: ["Swim Coach", "Grumpy Dad", "Benefactor", "Headmistress", "Queen Bee", "Bake Sale Queen"] },
      { name: "Small Town Bachelor Romance", books: ["Take Me Home", "Game Face", "Written in the Stars", "Walk With Me", "Stay the Night", "Come and Get It"] },
      { name: "Windy City Holidays", books: ["Pumpkin and Spice", "Comfort and Joy"] },
    ]},
    { id: "duets", name: "Duets", desc: "Companion books with crossover characters and/or locations.", series: [
      { name: "Duets", books: ["Her Devil Next Door", "Notes From Her Neighbor", "A Little Amusement", "The Bodyguard and his Bunny"] },
      { name: "Cowboy Up", books: ["Marrying Up", "Shacking Up", "Maid for the Billionaire", "Made for Marriage", "Doctor Dave", "Officer Max", "Saved for Me", "Matched for Me", "His Vinyl Vixen", "Her Hi-Fi Hunk", "Fencing Her In", "Doing Him Good", "Butter Queen", "Pumpkin King"] },
    ]},
    { id: "standalones", name: "Other Stand-alones", series: [
      { name: "Stand-alones", books: ["Not the Rebound Guy", "Naughty Irish Heart", "Fighting for Dylan", "511 Kissme Lane"] },
    ]},
  ];

  const esc = (s) => s.replace(/[&<>"']/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]));
  const find = (t) => known[t] || { url: "https://www.amazon.com/s?k=" + encodeURIComponent(t + " Abby Knox") };

  const list = document.getElementById("rlList");
  const jump = document.getElementById("rlJump");
  const total = universes.reduce((n, u) => n + u.series.reduce((m, s) => m + s.books.length, 0), 0);
  document.getElementById("rlStats").innerHTML =
    `<span><strong>${total}</strong> titles</span><span><strong>${universes.length}</strong> worlds</span><span><strong>${universes.reduce((n, u) => n + u.series.length, 0)}</strong> series &amp; collections</span>`;

  jump.innerHTML = universes.map((u) => `<a class="chip" href="#${u.id}">${esc(u.name)}</a>`).join("");

  list.innerHTML = universes.map((u) => `
    <section class="universe reveal" id="${u.id}" data-universe>
      <header class="universe-head">
        <h2>${esc(u.name)}</h2>
        ${u.desc ? `<p>${esc(u.desc)}</p>` : ""}
      </header>
      <div class="series-cards">
        ${u.series.map((s) => `
          <article class="series-card" data-series>
            <h3>${esc(s.name)}</h3>
            ${s.note ? `<p class="series-note">${esc(s.note)}</p>` : ""}
            <ol class="title-list">
              ${s.books.map((t, i) => {
                const k = find(t);
                return `<li data-title="${esc(t.toLowerCase())}">
                  <a href="${k.url}" target="_blank" rel="noopener">
                    ${k.img ? `<img src="${CDN}${k.img}?format=100w" alt="" loading="lazy" width="36" height="54" />` : `<span class="num">${i + 1}</span>`}
                    <span class="t">${esc(t)}</span>
                    <span class="go" aria-hidden="true">→</span>
                  </a>
                </li>`;
              }).join("")}
            </ol>
          </article>`).join("")}
      </div>
    </section>`).join("");

  // Search
  const input = document.getElementById("rlSearch");
  const empty = document.getElementById("rlEmpty");
  input.addEventListener("input", () => {
    const q = input.value.trim().toLowerCase();
    let shown = 0;
    list.querySelectorAll("[data-universe]").forEach((u) => {
      let uCount = 0;
      u.querySelectorAll("[data-series]").forEach((s) => {
        let sCount = 0;
        s.querySelectorAll("li").forEach((li) => {
          const hit = !q || li.dataset.title.includes(q) || s.querySelector("h3").textContent.toLowerCase().includes(q);
          li.hidden = !hit; if (hit) sCount++;
        });
        s.hidden = sCount === 0; uCount += sCount;
      });
      u.hidden = uCount === 0; shown += uCount;
      u.classList.add("in");
    });
    empty.hidden = shown > 0;
    jump.hidden = !!q;
  });
})();
