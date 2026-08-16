<?php
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\AdminProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['track.page.views', \App\Http\Middleware\TrackReferralCode::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog');
    Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
});

Route::get('/dashboard', [\App\Http\Controllers\UserDashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('/admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.admin');
    Route::get('analytics', [\App\Http\Controllers\Admin\AdminAnalyticsController::class, 'index'])->name('analytics.admin');
    Route::get('pages', [PageController::class, 'index'])->name('pages.admin');
    Route::get('pages/{slug}', [PageController::class, 'show'])->name('pages.show');
    Route::patch('pages/{slug}', [PageController::class, 'update'])->name('pages.update');

    //Projects
    Route::get('projects', [AdminProjectController::class, 'index'])->name('projects.admin');
    Route::get('projects/{slug}', [AdminProjectController::class, 'show'])->name('projects.show.admin');
    Route::patch('projects/{slug}', [AdminProjectController::class, 'update'])->name('projects.update.admin');
    Route::delete('projects/{slug}', [AdminProjectController::class, 'destroy'])->name('projects.destroy.admin');
    Route::post('projects', [AdminProjectController::class, 'store'])->name('projects.store.admin');

    //Messages
    Route::get('messages', [\App\Http\Controllers\Admin\AdminMessageController::class, 'index'])->name('messages.admin');
    Route::get('messages/{id}', [\App\Http\Controllers\Admin\AdminMessageController::class, 'show'])->name('messages.show.admin');
    Route::post('messages/{id}/reply', [\App\Http\Controllers\Admin\AdminMessageController::class, 'reply'])->name('messages.reply.admin');
    Route::patch('messages/{id}/status', [\App\Http\Controllers\Admin\AdminMessageController::class, 'updateStatus'])->name('messages.status.admin');
    Route::delete('messages/{id}', [\App\Http\Controllers\Admin\AdminMessageController::class, 'destroy'])->name('messages.destroy.admin');
    Route::post('messages/bulk', [\App\Http\Controllers\Admin\AdminMessageController::class, 'bulkAction'])->name('messages.bulk.admin');

    //Blog
    Route::get('blog', [\App\Http\Controllers\Admin\AdminBlogController::class, 'index'])->name('blog.admin');
    Route::get('blog/create', [\App\Http\Controllers\Admin\AdminBlogController::class, 'create'])->name('blog.create.admin');
    Route::post('blog', [\App\Http\Controllers\Admin\AdminBlogController::class, 'store'])->name('blog.store.admin');
    Route::get('blog/{slug}', [\App\Http\Controllers\Admin\AdminBlogController::class, 'show'])->name('blog.show.admin');
    Route::patch('blog/{slug}', [\App\Http\Controllers\Admin\AdminBlogController::class, 'update'])->name('blog.update.admin');
    Route::delete('blog/{slug}', [\App\Http\Controllers\Admin\AdminBlogController::class, 'destroy'])->name('blog.destroy.admin');

    //Admin Profile
    Route::get('profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('profile.admin');
    Route::patch('profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profile.update.admin');
    Route::put('profile/password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('profile.password.admin');

    //AI SDK Routes
    Route::post('ai/generate-blog', [\App\Http\Controllers\Admin\AdminAiController::class, 'generateBlog'])->name('ai.generate-blog.admin');
    Route::post('ai/generate-excerpt', [\App\Http\Controllers\Admin\AdminAiController::class, 'generateExcerpt'])->name('ai.generate-excerpt.admin');
    Route::post('ai/generate-project', [\App\Http\Controllers\Admin\AdminAiController::class, 'generateProject'])->name('ai.generate-project.admin');
    Route::post('ai/generate-bio', [\App\Http\Controllers\Admin\AdminAiController::class, 'generateBio'])->name('ai.generate-bio.admin');

    //Site Settings
    Route::get('settings', [\App\Http\Controllers\Admin\AdminSettingController::class, 'index'])->name('settings.admin');
    Route::patch('settings', [\App\Http\Controllers\Admin\AdminSettingController::class, 'update'])->name('settings.update.admin');

    //Email Templates & Settings
    Route::get('emails', [\App\Http\Controllers\Admin\AdminEmailController::class, 'index'])->name('emails.admin');
    Route::get('emails/create', [\App\Http\Controllers\Admin\AdminEmailController::class, 'create'])->name('emails.create.admin');
    Route::post('emails', [\App\Http\Controllers\Admin\AdminEmailController::class, 'store'])->name('emails.store.admin');
    Route::get('emails/{id}/edit', [\App\Http\Controllers\Admin\AdminEmailController::class, 'edit'])->name('emails.edit.admin');
    Route::patch('emails/{id}', [\App\Http\Controllers\Admin\AdminEmailController::class, 'update'])->name('emails.update.admin');
    Route::delete('emails/{id}', [\App\Http\Controllers\Admin\AdminEmailController::class, 'destroy'])->name('emails.destroy.admin');
    Route::post('emails/global', [\App\Http\Controllers\Admin\AdminEmailController::class, 'updateGlobal'])->name('emails.global.admin');
    Route::post('emails/test', [\App\Http\Controllers\Admin\AdminEmailController::class, 'sendTestEmail'])->name('emails.test.admin');

    //Work Experience
    Route::get('experiences', [\App\Http\Controllers\Admin\AdminExperienceController::class, 'index'])->name('experiences.admin');
    Route::get('experiences/create', [\App\Http\Controllers\Admin\AdminExperienceController::class, 'create'])->name('experiences.create.admin');
    Route::post('experiences', [\App\Http\Controllers\Admin\AdminExperienceController::class, 'store'])->name('experiences.store.admin');
    Route::get('experiences/{id}/edit', [\App\Http\Controllers\Admin\AdminExperienceController::class, 'edit'])->name('experiences.edit.admin');
    Route::patch('experiences/{id}', [\App\Http\Controllers\Admin\AdminExperienceController::class, 'update'])->name('experiences.update.admin');
    Route::delete('experiences/{id}', [\App\Http\Controllers\Admin\AdminExperienceController::class, 'destroy'])->name('experiences.destroy.admin');

    //Tech Stacks & Skills
    Route::get('stacks', [\App\Http\Controllers\Admin\AdminStackController::class, 'index'])->name('stacks.admin');
    Route::get('stacks/create', [\App\Http\Controllers\Admin\AdminStackController::class, 'create'])->name('stacks.create.admin');
    Route::post('stacks', [\App\Http\Controllers\Admin\AdminStackController::class, 'store'])->name('stacks.store.admin');
    Route::get('stacks/{id}/edit', [\App\Http\Controllers\Admin\AdminStackController::class, 'edit'])->name('stacks.edit.admin');
    Route::patch('stacks/{id}', [\App\Http\Controllers\Admin\AdminStackController::class, 'update'])->name('stacks.update.admin');
    Route::delete('stacks/{id}', [\App\Http\Controllers\Admin\AdminStackController::class, 'destroy'])->name('stacks.destroy.admin');

    //Code Snippets
    Route::get('snippets', [\App\Http\Controllers\Admin\AdminSnippetController::class, 'index'])->name('snippets.admin');
    Route::get('snippets/create', [\App\Http\Controllers\Admin\AdminSnippetController::class, 'create'])->name('snippets.create.admin');
    Route::post('snippets', [\App\Http\Controllers\Admin\AdminSnippetController::class, 'store'])->name('snippets.store.admin');
    Route::get('snippets/{id}/edit', [\App\Http\Controllers\Admin\AdminSnippetController::class, 'edit'])->name('snippets.edit.admin');
    Route::patch('snippets/{id}', [\App\Http\Controllers\Admin\AdminSnippetController::class, 'update'])->name('snippets.update.admin');
    Route::delete('snippets/{id}', [\App\Http\Controllers\Admin\AdminSnippetController::class, 'destroy'])->name('snippets.destroy.admin');

    //24/7 AI Sales Leads
    Route::get('ai-leads', [\App\Http\Controllers\Admin\AdminAiLeadController::class, 'index'])->name('ai-leads.admin');
    Route::get('ai-leads/{id}', [\App\Http\Controllers\Admin\AdminAiLeadController::class, 'show'])->name('ai-leads.show.admin');

    //Affiliates & Referrals
    Route::get('affiliates', [\App\Http\Controllers\Admin\AdminAffiliateController::class, 'index'])->name('affiliates.admin');
    Route::patch('affiliates/{id}', [\App\Http\Controllers\Admin\AdminAffiliateController::class, 'update'])->name('affiliates.update.admin');
});

//Public Feature Modules
Route::get('/snippets', [\App\Http\Controllers\SnippetController::class, 'index'])->name('snippets.index');
Route::get('/snippet/{slug}', [\App\Http\Controllers\SnippetController::class, 'show'])->name('snippets.show');
Route::get('/book-call', [\App\Http\Controllers\BookCallController::class, 'index'])->name('book-call');
Route::get('/resume/pdf', [\App\Http\Controllers\ResumePdfController::class, 'download'])->name('resume.pdf');
Route::get('/ai-assistant/history', [\App\Http\Controllers\AiChatbotController::class, 'history'])->name('ai-chatbot.history');
Route::post('/ai-assistant/chat', [\App\Http\Controllers\AiChatbotController::class, 'chat'])->name('ai-chatbot.chat');


require __DIR__.'/auth.php';
