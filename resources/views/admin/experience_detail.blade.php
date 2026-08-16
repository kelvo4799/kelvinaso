<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header">
        <div>
            <h1>{{ $isEdit ? 'Edit Experience: ' . $experience->title : 'Add Work Experience' }}</h1>
            <div class="sub">Configure position details, company name, timeframe, and key accomplishments.</div>
        </div>
        <div>
            <a href="{{ route('experiences.admin') }}" class="btn secondary">
                &larr; Back to Experiences
            </a>
        </div>
    </div>

    @if ($errors->any())
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; font-weight: 500; font-size: 0.9rem;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ $isEdit ? route('experiences.update.admin', $experience->id) : route('experiences.store.admin') }}" method="POST">
        @csrf
        @if ($isEdit)
            @method('PATCH')
        @endif

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

            <div style="display: flex; flex-direction: column; gap: 24px;">

                <div class="card">
                    <div class="card-head">
                        <h3>Position & Company Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="title">Job Title / Role</label>
                                    <input class="input" id="title" name="title" value="{{ old('title', $experience->title) }}" required placeholder="e.g. Senior Laravel Engineer" />
                                </div>
                                <div class="field">
                                    <label for="company">Company Name</label>
                                    <input class="input" id="company" name="company" value="{{ old('company', $experience->company) }}" required placeholder="e.g. Atlas Fintech Solutions" />
                                </div>
                            </div>

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="location">Location</label>
                                    <input class="input" id="location" name="location" value="{{ old('location', $experience->location) }}" placeholder="e.g. Lagos, Nigeria / Remote" />
                                </div>
                                <div class="field">
                                    <label for="employment_type">Employment Type</label>
                                    <input class="input" id="employment_type" name="employment_type" value="{{ old('employment_type', $experience->employment_type ?? 'Full-time') }}" placeholder="e.g. Full-time, Contract, Freelance" />
                                </div>
                            </div>

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="start_year">Start Date / Year</label>
                                    <input class="input" id="start_year" name="start_year" value="{{ old('start_year', $experience->start_year) }}" required placeholder="e.g. Jan 2023" />
                                </div>
                                <div class="field">
                                    <label for="end_year">End Date / Year</label>
                                    <input class="input" id="end_year" name="end_year" value="{{ old('end_year', $experience->end_year) }}" placeholder="e.g. Dec 2025 (Leave empty if current)" />
                                </div>
                            </div>

                            <div class="field">
                                <label for="description">Role Description & Achievements</label>
                                <textarea class="textarea" id="description" name="description" rows="6" placeholder="Describe key accomplishments, technologies used, and responsibilities...">{{ old('description', $experience->description) }}</textarea>
                            </div>

                        </div>
                    </div>
                    <div class="card-head" style="border-top: 1px solid var(--c-border); border-bottom: none; padding: 20px 28px;">
                        <button type="submit" class="btn primary-colored">
                            {{ $isEdit ? 'Save Experience Changes' : 'Create Work Experience' }}
                        </button>
                    </div>
                </div>

            </div>

            <div style="display: flex; flex-direction: column; gap: 24px;">

                <div class="card">
                    <div class="card-head">
                        <h3>Status & Options</h3>
                    </div>
                    <div class="card-body">
                        <div class="field" style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                            <input type="checkbox" id="is_current" name="is_current" value="1" {{ old('is_current', $experience->is_current) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                            <label for="is_current" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Currently Work Here (Present)</label>
                        </div>

                        <div class="field" style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $experience->is_active ?? true) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                            <label for="is_active" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Publish to Portfolio Website</label>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </form>

</x-admin-layout>
