@php
    $projectCard = $page->sections->where('section_name', 'project_card')->first();
@endphp


<x-main-layout :page="$page" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <main class="container" style="max-width:960px;">
  <div class="page-head">
    <p class="eyebrow">Contact · Available Q1 2026</p>
    <h1>Let's build something <span class="text-gradient">worth keeping</span>.</h1>
  </div>

  <div style="display:grid; grid-template-columns:1fr; gap:1.5rem; margin-top:2rem;" class="contact-tiles">
    <a href="mailto:hello@mayarivera.com" class="card" style="padding:2rem;">
      <p class="eyebrow" style="color:var(--muted);">Email</p>
      <p style="font-size:1.6rem; font-weight:600; margin-top:0.75rem;">hello@mayarivera.com →</p>
    </a>
    <a href="#" class="card" style="padding:2rem;">
      <p class="eyebrow" style="color:var(--muted);">Schedule a call</p>
      <p style="font-size:1.6rem; font-weight:600; margin-top:0.75rem;">Book 30 minutes →</p>
    </a>
  </div>
  <style>@media (min-width:700px){.contact-tiles{grid-template-columns:1fr 1fr !important;}}</style>

  <form id="contact-form" class="card form" novalidate style="margin-top:2.5rem;">
    <div>
      <p class="eyebrow">Or send a brief</p>
      <h2 style="margin-top:0.5rem;">Tell me about your project</h2>
    </div>
    <div class="form-grid">
      <div class="field" data-field="name">
        <label class="field-label" for="f-name">Name</label>
        <input class="input" id="f-name" name="name" type="text" autocomplete="name" maxlength="100" placeholder="Jane Doe" />
        <span class="field-error"></span>
      </div>
      <div class="field" data-field="email">
        <label class="field-label" for="f-email">Email</label>
        <input class="input" id="f-email" name="email" type="email" autocomplete="email" maxlength="255" placeholder="jane@company.com" />
        <span class="field-error"></span>
      </div>
    </div>
    <div class="field" data-field="subject">
      <label class="field-label" for="f-subject">Subject</label>
      <input class="input" id="f-subject" name="subject" type="text" maxlength="150" placeholder="Laravel backend for a fintech ledger" />
      <span class="field-error"></span>
    </div>
    <div class="field" data-field="message">
      <label class="field-label" for="f-message">Message</label>
      <textarea class="textarea" id="f-message" name="message" maxlength="2000" placeholder="A few lines on what you're building, timeline and budget."></textarea>
      <span class="field-error"></span>
    </div>
    <div class="form-footer">
      <p class="form-note">I read every message. Avg reply &lt; 48h.</p>
      <button type="submit" class="btn btn-primary">Send message</button>
    </div>
  </form>

  <div class="card" style="margin-top:2.5rem; padding:2rem;">
    <p class="eyebrow" style="color:var(--muted);">What I'm taking on</p>
    <ul style="list-style:none; padding:0; margin-top:1rem; display:flex; flex-direction:column; gap:0.75rem; font-size:1.05rem;">
      <li><span style="color:var(--accent); margin-right:0.5rem;">✦</span> Laravel backend engagements (6–12 weeks, embedded)</li>
      <li><span style="color:var(--accent); margin-right:0.5rem;">✦</span> Analytics dashboards & reporting infrastructure</li>
      <li><span style="color:var(--accent); margin-right:0.5rem;">✦</span> Data analysis projects, churn studies & cohort modelling</li>
    </ul>
  </div>
</main>
    
</x-main-layout>