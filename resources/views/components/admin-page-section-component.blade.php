@if ($page->title == 'home')

                <div class="section-item" data-section-id="sec_1">
                  <input type="hidden" class="section-type-input" name="sections[0][type]" value="hero" />
                  <input type="hidden" class="section-order-input" name="sections[0][order]" value="1" />
                  <div class="section-item-header" onclick="toggleSectionBody(this)">
                    <div class="section-header-left">
                      <span class="section-badge badge-purple">Hero</span>
                      <span class="section-item-title">Hero Header Banner</span>
                    </div>
                    
                  </div>
                  <div class="section-item-body">
                    <div class="form-grid">
                      <div class="field">
                        <label>Section Title</label>
                        <input class="input" name="sections[0][title]" value="Hero Header Banner" />
                      </div>
                      <div class="form-grid cols-2">
                        <div class="field">
                          <label>Headline</label>
                          <input class="input" name="sections[0][headline]" value="Hi, I'm Maya Rivera 👋" />
                        </div>
                        <div class="field">
                          <label>Subheadline / Tagline</label>
                          <input class="input" name="sections[0][subheadline]" value="Building scalable backend systems & data platforms" />
                        </div>
                      </div>
                      <div class="form-grid cols-2">
                        <div class="field">
                          <label>Primary Button Label</label>
                          <input class="input" name="sections[0][btn_text]" value="Explore Work" />
                        </div>
                        <div class="field">
                          <label>Primary Button URL</label>
                          <input class="input" name="sections[0][btn_url]" value="/work.html" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

@endif