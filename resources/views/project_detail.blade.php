<x-main-layout :page="$page" :settings="$settings ?? ['site_name' => 'Portfolio']">


    <section class="hero" style="position: relative;">
      
      

      <aside class="hero-aside animate-up delay-1">
        <div class="card profile hero-card">
          <a href="../work.html" class="back"
            style="display:inline-flex; align-items:center; gap:0.5rem; margin-bottom:2rem; color:var(--muted); font-size: 0.875rem; text-decoration:none; transition: color 0.2s;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
              <line x1="19" y1="12" x2="5" y2="12"></line>
              <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            All Work
          </a>

          <h3 style="margin-bottom: 1.5rem;">Project Info</h3>

          <dl class="meta-row"
            style="display: flex; flex-direction: column; gap: 1.25rem; border: none; padding: 0; margin: 0;">
            <div>
              <dt>Client</dt>
              <dd>Atlas Fintech</dd>
            </div>
            <div>
              <dt>Role</dt>
              <dd>Backend Engineer</dd>
            </div>
            <div>
              <dt>Category</dt>
              <dd>Laravel</dd>
            </div>
            <div>
              <dt>Year</dt>
              <dd>2024</dd>
            </div>
          </dl>

          <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border);">
            <p class="stack-title" style="margin-bottom: 1rem;">Technologies</p>
            <div class="chips" style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
              <span class="chip" style="flex: 1 1 auto; max-width: max-content; padding: 0.5rem 1rem;">Laravel 11</span>
              <span class="chip" style="flex: 1 1 auto; max-width: max-content; padding: 0.5rem 1rem;">PostgreSQL</span>
              <span class="chip" style="flex: 1 1 auto; max-width: max-content; padding: 0.5rem 1rem;">Redis</span>
              <span class="chip" style="flex: 1 1 auto; max-width: max-content; padding: 0.5rem 1rem;">Octane</span>
              <span class="chip" style="flex: 1 1 auto; max-width: max-content; padding: 0.5rem 1rem;">Pest</span>
            </div>
          </div>

          <a href="#" class="btn btn-primary" style="margin-top: 2rem; width: 100%;">
            View Source
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
              stroke-linecap="round">
              <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
              <polyline points="15 3 21 3 21 9" />
              <line x1="10" y1="14" x2="21" y2="3" />
            </svg>
          </a>
          <button data-preview="../assets/work-2.jpg" class="btn" style="margin-top: 0.75rem; width: 100%;">
            Live Preview
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
              stroke-linecap="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </button>
        </div>
      </aside>

      <div style="position: relative; z-index: 1;">
        <div class="card hero-card animate-up delay-2">
          <p class="eyebrow">Laravel · 2024</p>
          <h1 style="margin-top: 1rem;">Ledger <span class="text-gradient">API</span></h1>
          <p class="summary" style="color:var(--muted); font-size:1.15rem; margin-top:1.5rem; line-height:1.6;">
            A double-entry accounting API powering a fintech's core ledger. Built on Laravel Octane for
            sub-50ms response times under heavy concurrency, with full audit trails and ACID-safe posting.
          </p>
        </div>

        <div class="card stack animate-up delay-3" style="margin-top: 1.5rem; padding: 1rem;">
          <div class="detail-cover" style="margin: 0; border: none; border-radius: calc(var(--radius-xl) - 8px);">
            <img src="../assets/work-2.jpg" alt="Ledger API"
              style="border-radius: inherit; width: 100%; object-fit: cover;" />
          </div>
        </div>

        <div class="card metrics animate-up delay-4 hero-card"
          style="margin-top: 1.5rem; border-radius: var(--radius-xl);">
          <div>
            <p class="value">42ms</p>
            <p class="label">Avg response</p>
          </div>
          <div>
            <p class="value">94%</p>
            <p class="label">Test coverage</p>
          </div>
          <div>
            <p class="value">8k rps</p>
            <p class="label">Throughput</p>
          </div>
        </div>

        <div class="card animate-up delay-4 hero-card" style="margin-top: 1.5rem; border-radius: var(--radius-xl);">
          <div style="display: flex; flex-direction: column; gap: 3rem;">
            <div>
              <h2 style="font-size: 1.75rem;">The Challenge</h2>
              <p style="color:var(--muted); font-size:1.1rem; line-height:1.7; margin-top:1rem;">
                Atlas Fintech was struggling with database deadlocks and slow transaction posting as their user base
                rapidly scaled. Their legacy architecture could not guarantee atomicity under high concurrent load,
                risking out-of-sync balances. They needed a hyper-fast, rock-solid core ledger capable of processing
                thousands of financial events per minute without dropping or duplicating a single record.
              </p>
            </div>
            <div>
              <h2 style="font-size: 1.75rem;">Architecture & Approach</h2>
              <p style="color:var(--muted); font-size:1.1rem; line-height:1.7; margin-top:1rem;">
                I engineered a strict double-entry accounting system where every transaction enforces balanced debits
                and credits at the database level. To achieve the required sub-50ms latency, the API is served via
                <strong>Laravel Octane</strong> (powered by Swoole), keeping the framework booted in memory and
                drastically reducing overhead.
              </p>
              <p style="color:var(--muted); font-size:1.1rem; line-height:1.7; margin-top:1rem;">
                State mutations utilize aggressive pessimistic locking (<code>SELECT ... FOR UPDATE</code>) within
                PostgreSQL to ensure absolute ACID compliance during concurrent postings. Furthermore, the API enforces
                strict idempotency using Redis, completely neutralizing the risk of duplicate charges caused by
                unreliable mobile network retries.
              </p>

              <div class="card"
                style="margin: 2rem 0 0; padding: 0; overflow: hidden; background: #0f1016; border-color: rgba(255,255,255,0.1); box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                <div
                  style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; padding: 1rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(255,255,255,0.02);">
                  <div style="width: 12px; height: 12px; border-radius: 50%; background: #ef4444; flex-shrink: 0;">
                  </div>
                  <div style="width: 12px; height: 12px; border-radius: 50%; background: #eab308; flex-shrink: 0;">
                  </div>
                  <div style="width: 12px; height: 12px; border-radius: 50%; background: #22c55e; flex-shrink: 0;">
                  </div>
                  <div
                    style="margin-left: auto; color: #8b8d9a; font-size: 0.75rem; font-family: monospace; letter-spacing: 0.05em; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;">
                    POST /api/v1/ledger/entries</div>
                </div>
                <div style="padding: 1.5rem; overflow-x: auto;">
                  <pre
                    style="margin: 0; font-family: monospace; font-size: 0.85rem; line-height: 1.6; color: #e2e8f0; white-space: pre-wrap; word-break: break-all;">
<span style="color: #c678dd;">{</span>
  <span style="color: #e06c75;">"account_id"</span>: <span style="color: #98c379;">"acc_01H9X"</span>,
  <span style="color: #e06c75;">"amount"</span>: <span style="color: #d19a66;">25000</span>,
  <span style="color: #e06c75;">"currency"</span>: <span style="color: #98c379;">"USD"</span>,
  <span style="color: #e06c75;">"entry_type"</span>: <span style="color: #98c379;">"credit"</span>,
  <span style="color: #e06c75;">"idempotency_key"</span>: <span style="color: #98c379;">"req_992kxP"</span>,
  <span style="color: #e06c75;">"metadata"</span>: <span style="color: #c678dd;">{</span>
    <span style="color: #e06c75;">"stripe_charge"</span>: <span style="color: #98c379;">"ch_1N9b..."</span>
  <span style="color: #c678dd;">}</span>
<span style="color: #c678dd;">}</span></pre>
                </div>
              </div>
            </div>
            <div>
              <h2 style="font-size: 1.75rem;">The Results</h2>
              <p style="color:var(--muted); font-size:1.1rem; line-height:1.7; margin-top:1rem;">
                The new Ledger API launched seamlessly, migrating over 2 million historical accounts with zero downtime.
                API throughput increased by 800% while server resources were slashed in half thanks to Octane's raw
                efficiency. The finance team now operates with complete confidence, backed by immutable audit trails and
                94% test coverage via Pest PHP.
              </p>

              <div class="card"
                style="margin-top: 2.5rem; padding: 2rem; border-left: 4px solid var(--accent); background: rgba(240, 86, 58, 0.03);">
                <p style="font-size: 1.1rem; font-style: italic; line-height: 1.6; color: var(--fg);">"The Ledger API
                  rollout was flawless. Asonta delivered a robust, lightning-fast architecture that handles our peak
                  transaction periods without breaking a sweat. It's the most stable part of our stack."</p>
                <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1.5rem;">
                  <div
                    style="width: 40px; height: 40px; border-radius: 50%; background: var(--border-strong); display: flex; align-items: center; justify-content: center; font-weight: 600; color: var(--muted); font-size: 0.8rem;">
                    DC</div>
                  <div>
                    <p style="font-weight: 600; font-size: 0.9rem; margin: 0;">David Chen</p>
                    <p style="color: var(--muted); font-size: 0.8rem; margin: 0;">CTO, Atlas Fintech</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="animate-up delay-4" style="margin-top:4rem;">
          <div class="card hero-card"
            style="display:flex; flex-direction:column; align-items:center; text-align:center; margin-bottom: 0; border-radius: var(--radius-xl);">
            <p class="eyebrow" style="color:var(--muted); margin-bottom: 0.75rem;">Up Next</p>
            <h2 style="font-size: 2rem; margin-bottom: 0.75rem;">Churn Signals</h2>
            <p style="color:var(--muted); font-size:1.05rem; margin-bottom: 1.5rem; max-width: 400px;">A
              churn-prediction study across 18 months of usage data driving retention strategies.</p>
            <a href="churn-signals.html" class="btn btn-primary">
              Read Case Study
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" style="margin-left: 0.25rem;">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </section>

</x-main-layout>


