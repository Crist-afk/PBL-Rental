@extends('layouts.admin')

@section('title', 'CosRent - Forum Moderation')

@push('styles')
    <style>
        .forum-summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .forum-summary-card,
        .forum-table-wrapper {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            animation: fadeUp 0.5s ease both;
        }

        .forum-summary-card {
            padding: 20px;
        }

        .forum-summary-label {
            color: var(--text-3);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .forum-summary-value {
            color: var(--text-1);
            font-family: 'JetBrains Mono', monospace;
            font-size: 26px;
            font-weight: 800;
            margin-top: 8px;
        }

        .forum-table-wrapper {
            overflow: hidden;
            margin-bottom: 24px;
            animation-delay: 0.1s;
        }

        .forum-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .forum-table th {
            background: var(--brand-surface);
            border-bottom: 1px solid var(--border);
            color: var(--text-3);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .forum-table td {
            border-bottom: 1px solid var(--border);
            color: var(--text-2);
            padding: 16px;
            vertical-align: middle;
        }

        .forum-table tbody tr:last-child td {
            border-bottom: none;
        }

        .forum-table tbody tr:hover {
            background: var(--bg-hover);
        }

        .forum-title-cell {
            min-width: 260px;
        }

        .forum-title {
            color: var(--text-1);
            font-size: 14px;
            font-weight: 700;
            line-height: 1.4;
        }

        .forum-meta {
            color: var(--text-3);
            font-size: 11.5px;
            margin-top: 4px;
        }

        .forum-badge {
            background: var(--brand-surface-strong);
            border: 1px solid var(--border);
            border-radius: 999px;
            color: var(--text-1);
            display: inline-flex;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            white-space: nowrap;
        }

        .forum-count {
            color: var(--text-1);
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 700;
        }

        .forum-action {
            align-items: center;
            background: var(--brand-primary);
            border-radius: var(--radius-sm);
            color: var(--text-on-brand);
            display: inline-flex;
            font-size: 12px;
            font-weight: 700;
            gap: 7px;
            padding: 8px 12px;
            text-decoration: none;
            transition: all var(--tr);
            white-space: nowrap;
        }

        .forum-action:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        .forum-empty {
            color: var(--text-3);
            padding: 44px 20px;
            text-align: center;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 24px;
        }

        @media (max-width: 900px) {
            .forum-summary-grid {
                grid-template-columns: 1fr;
            }

            .forum-table-wrapper {
                overflow-x: auto;
            }

            .forum-table {
                min-width: 780px;
            }
        }
    </style>
@endpush

@section('content')
    <main class="main">
        <div class="main-inner">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Forum Moderation</h1>
                    <p class="page-sub">Review the latest community discussions without leaving the admin layout.</p>
                </div>
            </div>

            <div class="forum-summary-grid">
                <div class="forum-summary-card">
                    <div class="forum-summary-label">Posts Listed</div>
                    <div class="forum-summary-value">{{ $posts->count() }}</div>
                </div>
                <div class="forum-summary-card">
                    <div class="forum-summary-label">Total Posts</div>
                    <div class="forum-summary-value">{{ $posts->total() }}</div>
                </div>
                <div class="forum-summary-card">
                    <div class="forum-summary-label">Comments On Page</div>
                    <div class="forum-summary-value">{{ $posts->sum('comments_count') }}</div>
                </div>
            </div>

            <div class="forum-table-wrapper">
                <table class="forum-table">
                    <thead>
                        <tr>
                            <th>Post</th>
                            <th>Category</th>
                            <th>User</th>
                            <th>Comments</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td class="forum-title-cell">
                                    <div class="forum-title">{{ $post->title }}</div>
                                    <div class="forum-meta">#{{ $post->id }} / {{ $post->slug }}</div>
                                </td>
                                <td>
                                    <span class="forum-badge">{{ $post->category->name ?? '-' }}</span>
                                </td>
                                <td>{{ $post->user->nama ?? 'Deleted User' }}</td>
                                <td><span class="forum-count">{{ $post->comments_count }}</span></td>
                                <td>{{ $post->created_at?->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('forum.show', $post) }}" class="forum-action">
                                        View Public
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="forum-empty">
                                    No forum posts found yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($posts->hasPages())
                <div class="pagination-container">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </main>
@endsection
