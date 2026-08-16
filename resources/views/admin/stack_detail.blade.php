<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header">
        <div>
            <h1>{{ $isEdit ? 'Edit Skill: ' . $stack->name : 'Add Skill / Tech Stack' }}</h1>
            <div class="sub">Configure technology name, category, brand color, and proficiency level.</div>
        </div>
        <div>
            <a href="{{ route('stacks.admin') }}" class="btn secondary">
                &larr; Back to Skills
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

    <form action="{{ $isEdit ? route('stacks.update.admin', $stack->id) : route('stacks.store.admin') }}" method="POST">
        @csrf
        @if ($isEdit)
            @method('PATCH')
        @endif

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

            <div style="display: flex; flex-direction: column; gap: 24px;">

                <div class="card">
                    <div class="card-head">
                        <h3>Skill Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="name">Technology / Skill Name</label>
                                    <input class="input" id="name" name="name" value="{{ old('name', $stack->name) }}" required placeholder="e.g. Laravel" />
                                </div>
                                <div class="field">
                                    <label for="type">Category / Domain Type</label>
                                    <select class="input" id="type" name="type" required>
                                        <option value="language" {{ old('type', $stack->type) === 'language' ? 'selected' : '' }}>Programming Language</option>
                                        <option value="frontend" {{ old('type', $stack->type) === 'frontend' ? 'selected' : '' }}>Frontend Framework</option>
                                        <option value="backend" {{ old('type', $stack->type) === 'backend' ? 'selected' : '' }}>Backend Framework</option>
                                        <option value="database" {{ old('type', $stack->type) === 'database' ? 'selected' : '' }}>Database / Storage</option>
                                        <option value="devops" {{ old('type', $stack->type) === 'devops' ? 'selected' : '' }}>DevOps / Cloud</option>
                                        <option value="tool" {{ old('type', $stack->type) === 'tool' ? 'selected' : '' }}>Tool / IDE</option>
                                        <option value="mobile" {{ old('type', $stack->type) === 'mobile' ? 'selected' : '' }}>Mobile Development</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="color">Brand Color</label>
                                    <div style="display: flex; gap: 10px; align-items: center;">
                                        <input type="color" id="color_picker" value="{{ old('color', $stack->color ?? '#6366f1') }}" onchange="document.getElementById('color').value = this.value" style="width: 44px; height: 38px; padding: 2px; border-radius: var(--radius-sm); border: 1px solid var(--c-border); cursor: pointer; background: transparent;" />
                                        <input class="input" id="color" name="color" value="{{ old('color', $stack->color ?? '#6366f1') }}" onchange="document.getElementById('color_picker').value = this.value" placeholder="#6366f1" style="flex: 1;" />
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="level">Proficiency Level</label>
                                    <select class="input" id="level" name="level">
                                        <option value="expert" {{ old('level', $stack->level) === 'expert' ? 'selected' : '' }}>Expert / Master</option>
                                        <option value="pro" {{ old('level', $stack->level) === 'pro' ? 'selected' : '' }}>Pro / Senior</option>
                                        <option value="advanced" {{ old('level', $stack->level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
                                        <option value="intermediate" {{ old('level', $stack->level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-head" style="border-top: 1px solid var(--c-border); border-bottom: none; padding: 20px 28px;">
                        <button type="submit" class="btn primary-colored">
                            {{ $isEdit ? 'Save Skill Changes' : 'Create Skill Badge' }}
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
                            <input type="checkbox" id="is_lang" name="is_lang" value="1" {{ old('is_lang', $stack->is_lang) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                            <label for="is_lang" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Core Programming Language</label>
                        </div>

                        <div class="field" style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $stack->is_active ?? true) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                            <label for="is_active" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Display on Portfolio Website</label>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </form>

</x-admin-layout>
