<?php

namespace Tests\Feature;

use App\Http\Controllers\ForumController;
use App\Models\ForumCategory;
use App\Models\ForumComment;
use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class ForumFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_forum_index_returns_the_forum_view_with_category_data(): void
    {
        $request = Request::create(route('forum'), 'GET');
        $response = app(ForumController::class)->index($request);

        $this->assertInstanceOf(View::class, $response);
        $this->assertSame('forum', $response->name());
        $this->assertArrayHasKey('categories', $response->getData());
        $this->assertCount(4, $response->getData()['categories']);
    }

    public function test_authenticated_user_can_publish_a_forum_post(): void
    {
        $user = User::create([
            'nama' => 'Forum Tester',
            'email' => 'forum@test.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);

        $category = ForumCategory::where('slug', 'tips-cosplay')->firstOrFail();

        $response = $this->actingAs($user)->post(route('forum.store'), [
            'forum_category_id' => $category->id,
            'title' => 'Cara simpan wig setelah event',
            'content' => 'Aku ingin tahu cara simpan wig supaya tidak cepat kusut setelah dipakai seharian.',
        ]);

        $response->assertRedirect(route('forum'));
        $this->assertDatabaseHas('forum_posts', [
            'user_id' => $user->id,
            'forum_category_id' => $category->id,
            'title' => 'Cara simpan wig setelah event',
        ]);
    }

    public function test_forum_show_returns_detail_view_for_post(): void
    {
        $user = User::create([
            'nama' => 'Detail Tester',
            'email' => 'detail@test.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);

        $category = ForumCategory::where('slug', 'tips-cosplay')->firstOrFail();

        $post = ForumPost::create([
            'user_id' => $user->id,
            'forum_category_id' => $category->id,
            'title' => 'Tips styling armor',
            'slug' => 'tips-styling-armor',
            'content' => 'Aku sedang cari cara menyimpan armor EVA foam supaya tetap rapi.',
        ]);

        $response = app(ForumController::class)->show($post);

        $this->assertInstanceOf(View::class, $response);
        $this->assertSame('forum-detail', $response->name());
        $this->assertSame($post->id, $response->getData()['post']->id);
    }

    public function test_authenticated_user_can_add_a_comment_to_a_forum_post(): void
    {
        $user = User::create([
            'nama' => 'Komentar Tester',
            'email' => 'komentar@test.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);

        $category = ForumCategory::where('slug', 'cari-kostum')->firstOrFail();

        $post = ForumPost::create([
            'user_id' => $user->id,
            'forum_category_id' => $category->id,
            'title' => 'Cari vendor kostum Zhongli',
            'slug' => 'cari-vendor-kostum-zhongli',
            'content' => 'Ada yang tahu vendor terpercaya untuk kostum Zhongli ukuran L?',
        ]);

        $response = $this->actingAs($user)->post(route('forum.comments.store', $post), [
            'content' => 'Coba cek vendor yang biasa buka pre-order di Batam Centre.',
        ]);

        $response->assertRedirect(route('forum.show', $post));
        $this->assertDatabaseHas('forum_comments', [
            'forum_post_id' => $post->id,
            'user_id' => $user->id,
            'content' => 'Coba cek vendor yang biasa buka pre-order di Batam Centre.',
        ]);
    }

    public function test_authenticated_user_can_reply_to_a_comment(): void
    {
        $user = User::create([
            'nama' => 'Reply Tester',
            'email' => 'reply@test.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);

        $category = ForumCategory::where('slug', 'jadwal-event')->firstOrFail();

        $post = ForumPost::create([
            'user_id' => $user->id,
            'forum_category_id' => $category->id,
            'title' => 'Info event minggu depan',
            'slug' => 'info-event-minggu-depan',
            'content' => 'Ada kabar soal rundown event minggu depan?',
        ]);

        $comment = ForumComment::create([
            'forum_post_id' => $post->id,
            'user_id' => $user->id,
            'content' => 'Aku dengar rundown-nya keluar besok pagi.',
        ]);

        $response = $this->actingAs($user)->post(route('forum.comments.store', $post), [
            'parent_id' => $comment->id,
            'content' => 'Siap, nanti aku cek lagi informasinya.',
        ]);

        $response->assertRedirect(route('forum.show', $post));
        $this->assertDatabaseHas('forum_comments', [
            'forum_post_id' => $post->id,
            'user_id' => $user->id,
            'parent_id' => $comment->id,
            'content' => 'Siap, nanti aku cek lagi informasinya.',
        ]);
    }

    public function test_authenticated_user_can_update_own_forum_post(): void
    {
        $user = User::create([
            'nama' => 'Update Post Tester',
            'email' => 'update-post@test.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);

        $initialCategory = ForumCategory::where('slug', 'cari-kostum')->firstOrFail();
        $updatedCategory = ForumCategory::where('slug', 'tips-cosplay')->firstOrFail();

        $post = ForumPost::create([
            'user_id' => $user->id,
            'forum_category_id' => $initialCategory->id,
            'title' => 'Judul Lama',
            'slug' => 'judul-lama',
            'content' => 'Konten lama.',
        ]);

        $response = $this->actingAs($user)->patch(route('forum.update', $post), [
            'edit_forum_category_id' => $updatedCategory->id,
            'edit_title' => 'Judul Baru',
            'edit_content' => 'Konten sudah diperbarui.',
        ]);

        $response->assertRedirect(route('forum.show', $post));
        $this->assertDatabaseHas('forum_posts', [
            'id' => $post->id,
            'forum_category_id' => $updatedCategory->id,
            'title' => 'Judul Baru',
            'content' => 'Konten sudah diperbarui.',
        ]);
    }

    public function test_user_cannot_update_another_users_forum_post(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(HttpException::class);

        $owner = User::create([
            'nama' => 'Pemilik Post',
            'email' => 'owner-post@test.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);

        $otherUser = User::create([
            'nama' => 'Bukan Pemilik',
            'email' => 'other-post@test.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);

        $category = ForumCategory::where('slug', 'tips-cosplay')->firstOrFail();

        $post = ForumPost::create([
            'user_id' => $owner->id,
            'forum_category_id' => $category->id,
            'title' => 'Post Pemilik',
            'slug' => 'post-pemilik',
            'content' => 'Isi asli.',
        ]);

        $this->actingAs($otherUser)->patch(route('forum.update', $post), [
            'edit_forum_category_id' => $category->id,
            'edit_title' => 'Judul Disusupi',
            'edit_content' => 'Isi yang tidak boleh berubah.',
        ]);
    }

    public function test_authenticated_user_can_delete_own_forum_post(): void
    {
        $user = User::create([
            'nama' => 'Delete Post Tester',
            'email' => 'delete-post@test.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);

        $category = ForumCategory::where('slug', 'jadwal-event')->firstOrFail();

        $post = ForumPost::create([
            'user_id' => $user->id,
            'forum_category_id' => $category->id,
            'title' => 'Post Akan Dihapus',
            'slug' => 'post-akan-dihapus',
            'content' => 'Konten sementara.',
        ]);

        $response = $this->actingAs($user)->delete(route('forum.destroy', $post));

        $response->assertRedirect(route('forum'));
        $this->assertDatabaseMissing('forum_posts', [
            'id' => $post->id,
        ]);
    }

    public function test_authenticated_user_can_update_and_delete_own_comment(): void
    {
        $user = User::create([
            'nama' => 'Manage Comment Tester',
            'email' => 'manage-comment@test.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);

        $category = ForumCategory::where('slug', 'cari-kostum')->firstOrFail();

        $post = ForumPost::create([
            'user_id' => $user->id,
            'forum_category_id' => $category->id,
            'title' => 'Thread Untuk Komentar',
            'slug' => 'thread-untuk-komentar',
            'content' => 'Konten thread.',
        ]);

        $comment = ForumComment::create([
            'forum_post_id' => $post->id,
            'user_id' => $user->id,
            'content' => 'Komentar awal.',
        ]);

        $updateResponse = $this->actingAs($user)->patch(route('forum.comments.update', [$post, $comment]), [
            'edit_comment_content' => 'Komentar sudah diedit.',
        ]);

        $updateResponse->assertRedirect(route('forum.show', $post));
        $this->assertDatabaseHas('forum_comments', [
            'id' => $comment->id,
            'content' => 'Komentar sudah diedit.',
        ]);

        $deleteResponse = $this->actingAs($user)->delete(route('forum.comments.destroy', [$post, $comment]));

        $deleteResponse->assertRedirect(route('forum.show', $post));
        $this->assertDatabaseMissing('forum_comments', [
            'id' => $comment->id,
        ]);
    }
}
