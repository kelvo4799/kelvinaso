// Mobile nav toggle
document.addEventListener("click", (e) => {
  const t = e.target.closest("[data-nav-toggle]");
  if (t) {
    document.getElementById("mobile-menu")?.classList.toggle("open");
  }
});

// Toast helper
function showToast(message, type = "success") {
  const el = document.createElement("div");
  el.className = `toast ${type}`;
  el.textContent = message;
  document.body.appendChild(el);
  requestAnimationFrame(() => el.classList.add("show"));
  setTimeout(() => {
    el.classList.remove("show");
    setTimeout(() => el.remove(), 300);
  }, 3500);
}

// Contact form validation + submit
const form = document.getElementById("contact-form");
if (form) {
  const FORM_ENDPOINT = "https://example.com/your-form-endpoint";

  const validators = {
    name: (v) => {
      v = v.trim();
      if (!v) return "Name is required";
      if (v.length > 100) return "Name must be under 100 characters";
      return "";
    },
    email: (v) => {
      v = v.trim();
      if (!v) return "Email is required";
      if (v.length > 255) return "Email must be under 255 characters";
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return "Enter a valid email";
      return "";
    },
    subject: (v) => {
      v = v.trim();
      if (!v) return "Subject is required";
      if (v.length > 150) return "Subject must be under 150 characters";
      return "";
    },
    message: (v) => {
      v = v.trim();
      if (v.length < 10) return "Message should be at least 10 characters";
      if (v.length > 2000) return "Message must be under 2000 characters";
      return "";
    },
  };

  function setError(name, msg) {
    const field = form.querySelector(`[data-field="${name}"]`);
    if (!field) return;
    field.classList.toggle("has-error", !!msg);
    const errEl = field.querySelector(".field-error");
    if (errEl) errEl.textContent = msg;
  }

  // Live validation
  form.querySelectorAll("input, textarea").forEach((input) => {
    input.addEventListener("blur", () => {
      const v = validators[input.name];
      if (v) setError(input.name, v(input.value));
    });
    input.addEventListener("input", () => {
      const field = input.closest(".field");
      if (field?.classList.contains("has-error")) {
        const v = validators[input.name];
        if (v) setError(input.name, v(input.value));
      }
    });
  });

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(form));
    let valid = true;
    Object.entries(validators).forEach(([name, fn]) => {
      const msg = fn(data[name] ?? "");
      setError(name, msg);
      if (msg) valid = false;
    });
    if (!valid) return;

    const btn = form.querySelector("[type='submit']");
    btn.disabled = true;
    const original = btn.textContent;
    btn.textContent = "Sending…";
    try {
      const res = await fetch(FORM_ENDPOINT, {
        method: "POST",
        headers: { "Content-Type": "application/json", Accept: "application/json" },
        body: JSON.stringify(data),
      });
      if (!res.ok) throw new Error("network");
      showToast("Message sent — I'll get back to you within 48h.");
      form.reset();
    } catch {
      showToast("Couldn't send the message. Try email instead.", "error");
    } finally {
      btn.disabled = false;
      btn.textContent = original;
    }
  });
}

// Works grid: filter + pagination
const worksRoot = document.getElementById("works");
if (worksRoot) {
  const PER_PAGE = parseInt(worksRoot.dataset.perPage || "6", 10);
  const cards = Array.from(worksRoot.querySelectorAll("[data-work]"));
  const tabs = Array.from(worksRoot.querySelectorAll("[data-tab]"));
  const pagination = worksRoot.querySelector("[data-pagination]");
  let category = "All";
  let page = 1;

  function render() {
    const filtered = cards.filter(
      (c) => category === "All" || c.dataset.category === category,
    );
    cards.forEach((c) => (c.style.display = "none"));
    const totalPages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
    if (page > totalPages) page = totalPages;
    const start = (page - 1) * PER_PAGE;
    filtered.slice(start, start + PER_PAGE).forEach((c) => (c.style.display = ""));

    tabs.forEach((t) => t.classList.toggle("active", t.dataset.tab === category));

    pagination.innerHTML = "";
    if (totalPages <= 1) return;

    const mkBtn = (label, opts = {}) => {
      const b = document.createElement("button");
      b.className = "page-btn" + (opts.active ? " active" : "");
      b.textContent = label;
      if (opts.disabled) b.disabled = true;
      if (opts.onClick) b.addEventListener("click", opts.onClick);
      return b;
    };

    pagination.appendChild(
      mkBtn("← Prev", {
        disabled: page === 1,
        onClick: () => { page = Math.max(1, page - 1); render(); window.scrollTo({ top: worksRoot.offsetTop - 80, behavior: "smooth" }); },
      }),
    );
    for (let i = 1; i <= totalPages; i++) {
      pagination.appendChild(
        mkBtn(String(i), {
          active: i === page,
          onClick: () => { page = i; render(); window.scrollTo({ top: worksRoot.offsetTop - 80, behavior: "smooth" }); },
        }),
      );
    }
    pagination.appendChild(
      mkBtn("Next →", {
        disabled: page === totalPages,
        onClick: () => { page = Math.min(totalPages, page + 1); render(); window.scrollTo({ top: worksRoot.offsetTop - 80, behavior: "smooth" }); },
      }),
    );
  }

  tabs.forEach((t) =>
    t.addEventListener("click", () => {
      category = t.dataset.tab;
      page = 1;
      render();
    }),
  );

  render();
}
