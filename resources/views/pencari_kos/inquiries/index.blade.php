@extends('layouts.admin')

@section('content')
    <div class="page-header" style="margin-bottom: 24px;">
        <div>
            <h1 class="page-title">Pusat Komunikasi Strategis</h1>
            <p class="page-subtitle">Manifes Pesan: Rekam Jejak Konsultasi Properti dengan Pemilik Properti</p>
        </div>
        <div class="page-actions">
            <div class="badge badge-primary"
                style="border-radius: 100px; padding: 10px 20px; font-weight: 800; font-size: 11px; letter-spacing: 0.05em;">
                AUDIT KOMUNIKASI AKTIF</div>
        </div>
    </div>

    <div class="chat-container">
        <!-- LEFT PANEL: THREAD LIST -->
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <div style="font-family: 'Syne'; font-weight: 800; font-size: 16px; color: var(--text);">Daftar Konsultasi
                </div>
            </div>

            <div class="thread-list" style="flex: 1; overflow-y: auto;">
                @forelse($threads as $thread)
                    <a href="{{ route('pencari-kos.inquiries.index', ['thread' => $thread->listing_id]) }}"
                        class="thread-item {{ (isset($activeThread) && $activeThread->id === $thread->listing_id) ? 'active' : '' }}">
                        <div class="thread-av">
                            {{ substr($thread->listing->name, 0, 1) }}
                        </div>
                        <div class="thread-meta">
                            <div class="thread-top">
                                <span class="thread-name">{{ $thread->listing->name }}</span>
                                <span class="thread-time">{{ $thread->created_at->format('H:i') }}</span>
                            </div>
                            <p class="thread-last-msg">{{ Str::limit($thread->message, 40) }}</p>
                        </div>
                    </a>
                @empty
                    <div style="padding: 40px 20px; text-align: center; opacity: 0.5;">
                        <div style="font-size: 32px; margin-bottom: 12px;">✉️</div>
                        <div style="font-size: 12px; font-weight: 700;">Belum ada konsultasi</div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- MAIN CHAT PANEL -->
        @if($activeThread)
            <div class="chat-main">
                <div class="chat-header">
                    <div class="chat-focus-info">
                        <div class="focus-thumb">
                            @if($activeThread->main_photo)
                                <img src="{{ asset('storage/' . $activeThread->main_photo) }}">
                            @else
                                <div class="focus-placeholder">🏡</div>
                            @endif
                        </div>
                        <div>
                            <div class="focus-title">{{ $activeThread->name }}</div>
                            <div class="focus-subtitle">{{ strtoupper($activeThread->city) }} • Pemilik:
                                {{ $activeThread->user->name }}</div>
                        </div>
                    </div>
                    <a href="{{ route('pencari-kos.discovery.show', $activeThread->id) }}" class="btn btn-outline"
                        style="border-radius: 100px; font-size: 11px; padding: 8px 20px; font-weight: 800;">LIHAT KOS</a>
                </div>

                <div class="chat-body" id="chatThread">
                    @forelse($messages as $msg)
                        <div class="chat-msg {{ $msg->sender_id === auth()->id() ? 'msg-me' : 'msg-them' }}">
                            <div class="msg-bubble">
                                {{ $msg->message }}
                                <div class="msg-time">{{ $msg->created_at->format('H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 100px 0; opacity: 0.3;">
                            <div style="font-size: 48px; margin-bottom: 16px;">💬</div>
                            <div style="font-weight: 800; font-family: 'Syne';">MULAI KONSULTASI STRATEGIS</div>
                        </div>
                    @endforelse
                </div>

                <div class="chat-footer">
                    <form action="{{ route('pencari-kos.inquiries.respond', $activeThread->id) }}" method="POST">
                        @csrf
                        <div class="chat-input-wrap">
                            <input type="text" name="message" id="msgInput" placeholder="Tulis pesan lanjutan..."
                                autocomplete="off" required>
                            <button type="submit" class="chat-send-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="22" y1="2" x2="11" y2="13" />
                                    <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="chat-main empty-state">
                <div style="text-align: center;">
                    <div style="font-size: 80px; margin-bottom: 24px;">🛸</div>
                    <h3 style="font-family: 'Syne'; font-weight: 800; font-size: 24px; color: var(--text);">Pilih Konsultasi
                    </h3>
                    <p style="color: var(--text-muted); font-weight: 600;">Silakan pilih salah satu daftar properti di sebelah
                        kiri untuk melihat histori audit komunikasi.</p>
                </div>
            </div>
        @endif
    </div>

    <style>
        /* Refined Chat Aesthetics based on Pemilik Show */
        .chat-container {
            display: flex;
            height: calc(100vh - 220px);
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.05);
        }

        .chat-sidebar {
            width: 320px;
            background: #f9fafb;
            border-right: 1.5px solid var(--border);
            display: flex;
            flex-direction: column;
        }

        .chat-sidebar-header {
            padding: 24px;
            border-bottom: 1px solid var(--border);
        }

        .thread-list {
            flex: 1;
            overflow-y: auto;
        }

        .thread-item {
            display: flex;
            gap: 16px;
            padding: 20px 24px;
            text-decoration: none;
            transition: 0.3s;
            border-bottom: 1px solid var(--border);
            align-items: center;
        }

        .thread-item:hover {
            background: #fff;
        }

        .thread-item.active {
            background: #fff;
            border-left: 4px solid var(--primary);
        }

        .thread-av {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary-glow);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-family: 'Syne';
            flex-shrink: 0;
        }

        .thread-meta {
            flex: 1;
            min-width: 0;
        }

        .thread-top {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 4px;
        }

        .thread-name {
            font-size: 14px;
            font-weight: 800;
            color: var(--text);
            font-family: 'Syne';
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .thread-time {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 700;
        }

        .thread-last-msg {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 0;
        }

        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .chat-main.empty-state {
            align-items: center;
            justify-content: center;
            background: #fafafa;
        }

        .chat-header {
            padding: 20px 32px;
            border-bottom: 1.5px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
        }

        .chat-focus-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .focus-thumb {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            overflow: hidden;
            background: #eee;
        }

        .focus-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .focus-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--border);
            font-size: 20px;
        }

        .focus-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--text);
            font-family: 'Syne';
            line-height: 1.2;
        }

        .focus-subtitle {
            font-size: 11px;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 0.05em;
            margin-top: 2px;
        }

        .chat-body {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
            background: rgba(var(--bg-rgb), 0.3);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .chat-msg {
            display: flex;
            width: 100%;
        }

        .msg-me {
            justify-content: flex-end;
        }

        .msg-them {
            justify-content: flex-start;
        }

        .msg-bubble {
            max-width: 65%;
            padding: 14px 20px;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.6;
            position: relative;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .msg-me .msg-bubble {
            background: var(--primary);
            color: #fff;
            border-radius: 20px 20px 4px 20px;
            box-shadow: 0 10px 25px -5px rgba(var(--primary-rgb), 0.3);
        }

        .msg-them .msg-bubble {
            background: #fff;
            color: var(--text);
            border-radius: 20px 20px 20px 4px;
            border: 1.5px solid var(--border);
        }

        .msg-time {
            font-size: 10px;
            margin-top: 6px;
            opacity: 0.6;
            text-align: right;
            font-weight: 700;
        }

        .msg-me .msg-time {
            color: #fff;
        }

        .chat-footer {
            padding: 24px 32px;
            background: #fff;
            border-top: 1.5px solid var(--border);
        }

        .chat-input-wrap {
            display: flex;
            background: #f3f4f6;
            border: 1.5px solid var(--border);
            border-radius: 100px;
            padding: 6px 6px 6px 24px;
            align-items: center;
            transition: 0.3s;
        }

        .chat-input-wrap:focus-within {
            background: #fff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.1);
        }

        #msgInput {
            flex: 1;
            background: none;
            border: none;
            padding: 12px 0;
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            outline: none;
        }

        .chat-send-btn {
            width: 48px;
            height: 48px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .chat-send-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.3);
        }

        .chat-send-btn svg {
            width: 22px;
            height: 22px;
            margin-left: 2px;
        }
    </style>

    <script>
        // Scroll to bottom on load
        const thread = document.getElementById('chatThread');
        if (thread) {
            thread.scrollTop = thread.scrollHeight;
        }
    </script>
@endsection