@auth
    <!-- Notification dropdown -->
    <div style="position:relative;">
        <button class="notif-btn" onclick="toggleNotifDropdown()" id="notif-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            @if($unreadNotificationsCount > 0)
                <span class="notif-badge">{{ $unreadNotificationsCount }}</span>
            @endif
        </button>
        <div class="admin-dropdown notif-dropdown" id="notif-dropdown">
            <div class="dropdown-header" style="display: flex; justify-content: space-between; align-items: center;">
                <strong>Pusat Notifikasi</strong>
                @if($unreadNotificationsCount > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" style="font-size: 11px; color: var(--primary); border: none; background: none; cursor: pointer;">Tandai semua dibaca</button>
                </form>
                @endif
            </div>
            <div class="notif-list" style="max-height: 320px; overflow-y: auto;">
                @if(isset($unreadInquiriesCount) && $unreadInquiriesCount > 0)
                    <div class="dropdown-item unread" style="padding: 12px 16px; border-bottom: 1px solid var(--border); border-radius: 0; display: block; background: rgba(var(--primary-rgb), 0.05);">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 8px; height: 8px; background: var(--primary); border-radius: 50%;"></div>
                            <div style="font-size: 13px; font-weight: 700; color: var(--text);">{{ $unreadInquiriesCount }} Pesan Baru</div>
                        </div>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px; line-height: 1.4;">Ada pertanyaan baru mengenai properti Anda.</div>
                        @php
                            $inquiryRoute = '#';
                            if(auth()->user()->hasRole('super-admin')) $inquiryRoute = route('moderation');
                            elseif(auth()->user()->hasRole('pemilik-kos')) $inquiryRoute = route('pemilik-kos.inquiries.index');
                            elseif(auth()->user()->hasRole('pencari-kos')) $inquiryRoute = route('pencari-kos.inquiries.index');
                        @endphp
                        <a href="{{ $inquiryRoute }}" style="font-size: 11px; color: var(--primary); font-weight: 600; text-decoration: none; margin-top: 8px; display: inline-block;">Buka Kotak Masuk →</a>
                    </div>
                @endif

                @forelse($recentNotifications as $notification)
                    <div class="dropdown-item {{ $notification->read_at ? '' : 'unread' }}" style="padding: 12px 16px; border-bottom: 1px solid var(--border); border-radius: 0; display: block;">
                        <div style="font-size: 13px; font-weight: 500; color: var(--text);">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</div>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px; line-height: 1.4;">{{ $notification->data['message'] ?? '' }}</div>
                        <div style="font-size: 10px; color: var(--text-muted); margin-top: 6px;">{{ $notification->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="dropdown-item" style="padding: 24px; text-align: center; color: var(--text-muted); display: block;">
                        Belum ada pemberitahuan baru
                    </div>
                @endforelse
            </div>
            <a href="{{ route('notifications.index') }}" class="dropdown-footer" style="display: block; padding: 12px; text-align: center; font-size: 12px; font-weight: 600; color: var(--primary); border-top: 1px solid var(--border);">
                Lihat Seluruh Aktivitas
            </a>
        </div>
    </div>
@endauth
