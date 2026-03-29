@extends('layouts.admin')

@section('content')
<div class="chat-container">
    <!-- LEFT PANEL: THREAD INFO -->
    <div class="chat-sidebar">
        <div class="chat-sidebar-header">
            <a href="{{ route('pemilik-kos.inquiries.index') }}" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>
        
        <div class="chat-focus-card">
            <div class="listing-info-mini">
                <div class="mini-thumb">
                    @if($listing->main_photo)
                        <img src="{{ asset('storage/' . $listing->main_photo) }}">
                    @else
                        <div class="mini-placeholder">🏡</div>
                    @endif
                </div>
                <div class="mini-details">
                    <div class="mini-label">Property Terkait</div>
                    <div class="mini-title">{{ $listing->name }}</div>
                </div>
            </div>

            <div class="client-info-card">
                <div class="client-av">
                    {{ strtoupper(substr($client->name, 0, 1)) }}
                </div>
                <div class="client-meta">
                    <strong>{{ $client->name }}</strong>
                    <span>Calon Penyewa</span>
                </div>
                <div class="client-actions">
                    <a href="mailto:{{ $client->email }}" class="act-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Email
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CHAT PANEL -->
    <div class="chat-main">
        <div class="chat-header">
            <div class="chat-user-status">
                <div class="status-dot online"></div>
                <span>{{ $client->name }}</span>
            </div>
        </div>

        <div class="chat-body" id="chatThread">
            @foreach($messages as $msg)
                <div class="chat-msg {{ $msg->sender_id === auth()->id() ? 'msg-me' : 'msg-them' }}">
                    <div class="msg-bubble">
                        {{ $msg->message }}
                        <div class="msg-time">{{ $msg->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="chat-footer">
            <form action="{{ route('pemilik-kos.inquiries.respond', $messages->last()->id) }}" method="POST" id="msgForm">
                @csrf
                <div class="chat-input-wrap">
                    <input type="text" name="message" id="msgInput" placeholder="Tulis pesan Anda..." autocomplete="off" required>
                    <button type="submit" class="chat-send-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Chat Specific Styling to achieve Two-Way Chat Aesthetic */
.chat-container {
    display: flex;
    height: calc(100vh - 120px);
    background: var(--bg);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
}

.chat-sidebar {
    width: 320px;
    background: var(--surface);
    border-right: 1.5px solid var(--border);
    display: flex;
    flex-direction: column;
}

.chat-sidebar-header {
    padding: 20px;
    border-bottom: 1px solid var(--border);
}

.back-link {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-muted);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s;
}

.back-link:hover { color: var(--primary); }
.back-link svg { width: 18px; height: 18px; }

.chat-focus-card { padding: 20px; }

.listing-info-mini {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
    padding: 12px;
    background: var(--bg);
    border-radius: 12px;
}

.mini-thumb { width: 44px; height: 44px; border-radius: 8px; overflow: hidden; }
.mini-thumb img { width: 100%; height: 100%; object-fit: cover; }
.mini-placeholder { width: 100%; height: 100%; background: var(--border); display: flex; align-items: center; justify-content: center; font-size: 20px; }

.mini-label { font-size: 10px; color: var(--text-muted); text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; }
.mini-title { font-size: 13px; font-weight: 800; color: var(--text); }

.client-info-card {
    text-align: center;
    padding: 24px 16px;
    background: var(--primary-glow);
    border-radius: 16px;
    border: 1.5px solid rgba(var(--primary-rgb), 0.1);
}

.client-av {
    width: 64px;
    height: 64px;
    background: var(--primary);
    color: #fff;
    border-radius: 50%;
    margin: 0 auto 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 800;
    box-shadow: 0 8px 16px rgba(var(--primary-rgb), 0.2);
}

.client-meta strong { display: block; font-size: 16px; color: var(--text); }
.client-meta span { font-size: 12px; color: var(--text-muted); font-weight: 600; }

.client-actions { margin-top: 20px; }
.act-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #fff;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 700;
    color: var(--primary);
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #fff;
}

.chat-header {
    padding: 16px 24px;
    border-bottom: 1.5px solid var(--border);
    display: flex;
    align-items: center;
}

.chat-user-status { display: flex; align-items: center; gap: 8px; }
.status-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--muted); }
.status-dot.online { background: #22c55e; box-shadow: 0 0 10px rgba(34, 197, 94, 0.4); }
.chat-user-status span { font-weight: 800; color: var(--text); font-size: 15px; }

.chat-body {
    flex: 1;
    padding: 24px;
    overflow-y: auto;
    background: rgba(var(--bg-rgb), 0.3);
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.chat-msg { display: flex; width: 100%; }
.msg-me { justify-content: flex-end; }
.msg-them { justify-content: flex-start; }

.msg-bubble {
    max-width: 60%;
    padding: 12px 16px;
    font-size: 14px;
    line-height: 1.5;
    position: relative;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}

.msg-me .msg-bubble {
    background: var(--primary);
    color: #fff;
    border-radius: 18px 18px 2px 18px;
}

.msg-them .msg-bubble {
    background: #fff;
    color: var(--text);
    border-radius: 18px 18px 18px 2px;
    border: 1.5px solid var(--border);
}

.msg-time {
    font-size: 10px;
    margin-top: 4px;
    opacity: 0.7;
    text-align: right;
}

.chat-footer {
    padding: 20px 24px;
    background: #fff;
    border-top: 1.5px solid var(--border);
}

.chat-input-wrap {
    display: flex;
    background: var(--bg);
    border: 1.5px solid var(--border);
    border-radius: 100px;
    padding: 6px 6px 6px 20px;
    align-items: center;
    transition: 0.2s;
}

.chat-input-wrap:focus-within { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.08); }

#msgInput {
    flex: 1;
    background: none;
    border: none;
    padding: 10px 0;
    font-size: 14px;
    font-weight: 500;
    color: var(--text);
    outline: none;
}

.chat-send-btn {
    width: 44px;
    height: 44px;
    background: var(--primary);
    color: #fff;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.2s;
}

.chat-send-btn:hover { transform: scale(1.05); box-shadow: 0 8px 16px rgba(var(--primary-rgb), 0.3); }
.chat-send-btn svg { width: 22px; height: 22px; margin-left: 2px; }

</style>

<script>
    // Scroll to bottom on load
    const thread = document.getElementById('chatThread');
    thread.scrollTop = thread.scrollHeight;
</script>
@endsection
