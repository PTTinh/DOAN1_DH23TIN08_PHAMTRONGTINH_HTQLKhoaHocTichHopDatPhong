<section
    class="edu-chatbot"
    id="eduChatbot"
    data-chat-endpoint="{{ route('chatbot.message') }}"
    data-history-endpoint="{{ route('chatbot.history') }}"
    data-clear-endpoint="{{ route('chatbot.clear') }}"
    data-csrf-token="{{ csrf_token() }}"
>
    <article class="edu-chatbot__popup" id="eduChatPopup" aria-hidden="true">
        <header class="edu-chatbot__header">
            <div>
                <h3 class="edu-chatbot__title">Trợ lý học tập {{ App\Helpers\SettingHelper::get('center_name', 'EduSmart') }}</h3>
                <p class="edu-chatbot__status">Đang trực tuyến</p>
            </div>
            <button class="edu-chatbot__icon-btn" type="button" id="eduChatClose" aria-label="Đóng">&times;</button>
        </header>

        <div class="edu-chatbot__body" id="eduChatBody">
            <div class="edu-chatbot__bubble edu-chatbot__bubble--bot">Xin chào bạn, mình có thể hỗ trợ tư vấn khóa học, lịch học và học phí.</div>
        </div>

        <footer class="edu-chatbot__footer">
            <div class="edu-chatbot__input-row">
                <input class="edu-chatbot__input" id="eduChatInput" type="text" placeholder="Nhập tin nhắn..." maxlength="2000" aria-label="Nhập tin nhắn">
                <button class="edu-chatbot__send" id="eduChatSend" type="button">Gửi</button>
            </div>
            <div class="edu-chatbot__chips" id="eduChatChips">
                <button class="edu-chatbot__chip" type="button">Khóa học</button>
                <button class="edu-chatbot__chip" type="button">Đặt phòng</button>
                <button class="edu-chatbot__chip" type="button">Lịch học</button>
                <button class="edu-chatbot__chip" type="button">Học phí</button>
            </div>
        </footer>
    </article>

    <button class="edu-chatbot__toggle" id="eduChatToggle" type="button" aria-label="Mở chatbot" aria-expanded="false">
        <svg class="edu-chatbot__robot" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M11 2h2v2h3a4 4 0 0 1 4 4v7a5 5 0 0 1-5 5h-1v2h-2v-2h-2v2H8v-2H7a5 5 0 0 1-5-5V8a4 4 0 0 1 4-4h3V2Zm-5 6a2 2 0 0 0-2 2v5a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-5a2 2 0 0 0-2-2H6Zm2.75 3.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Zm6.5 0a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Z"/>
        </svg>
    </button>
</section>

<script>
    (function () {
        const root = document.getElementById('eduChatbot');
        if (!root) return;

        const popup = document.getElementById('eduChatPopup');
        const toggle = document.getElementById('eduChatToggle');
        const closeBtn = document.getElementById('eduChatClose');
        const body = document.getElementById('eduChatBody');
        const input = document.getElementById('eduChatInput');
        const send = document.getElementById('eduChatSend');
        const chips = document.getElementById('eduChatChips');

        const endpoints = {
            chat: root.dataset.chatEndpoint,
            history: root.dataset.historyEndpoint,
            clear: root.dataset.clearEndpoint,
            csrf: root.dataset.csrfToken,
        };

        let loadedHistory = false;

        const escapeHtml = (text) => (text || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        const formatMessage = (message) => {
            const escaped = escapeHtml(message || '');

            return escaped
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\n/g, '<br>');
        };

        const appendBubble = (role, message) => {
            const bubble = document.createElement('div');
            bubble.className = `edu-chatbot__bubble ${role === 'user' ? 'edu-chatbot__bubble--user' : 'edu-chatbot__bubble--bot'}`;
            bubble.innerHTML = formatMessage(message);
            body.appendChild(bubble);
            body.scrollTop = body.scrollHeight;
        };

        const appendTyping = () => {
            const wrapper = document.createElement('div');
            wrapper.className = 'edu-chatbot__typing';
            wrapper.id = 'eduChatTyping';
            wrapper.innerHTML = '<span></span><span></span><span></span>';
            body.appendChild(wrapper);
            body.scrollTop = body.scrollHeight;
        };

        const removeTyping = () => {
            const typing = document.getElementById('eduChatTyping');
            if (typing) typing.remove();
        };

        const openPopup = async () => {
            popup.classList.add('is-open');
            popup.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            setTimeout(() => input.focus(), 120);

            if (!loadedHistory) {
                loadedHistory = true;
                try {
                    const response = await fetch(endpoints.history, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        credentials: 'same-origin',
                    });

                    const result = await response.json();
                    if (result.success && Array.isArray(result.messages) && result.messages.length > 0) {
                        body.innerHTML = '';
                        result.messages.forEach((item) => appendBubble(item.role, item.message));
                    }
                } catch (error) {
                    console.error('Failed to load chat history', error);
                }
            }
        };

        const closePopup = () => {
            popup.classList.remove('is-open');
            popup.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
        };

        const sendMessage = async (text) => {
            const message = (text || '').trim();
            if (!message) return;

            appendBubble('user', message);
            input.value = '';
            appendTyping();

            try {
                const response = await fetch(endpoints.chat, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': endpoints.csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ message }),
                });

                const result = await response.json();
                removeTyping();

                if (result.success) {
                    appendBubble('assistant', result.message);
                } else {
                    appendBubble('assistant', 'Xin lỗi, hệ thống đang bận. Vui lòng thử lại sau.');
                }
            } catch (error) {
                removeTyping();
                appendBubble('assistant', 'Xin lỗi, không thể kết nối máy chủ lúc này.');
                console.error('Chat error', error);
            }
        };

        toggle.addEventListener('click', () => {
            if (popup.classList.contains('is-open')) {
                closePopup();
            } else {
                openPopup();
            }
        });

        closeBtn.addEventListener('click', closePopup);

        send.addEventListener('click', () => sendMessage(input.value));

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                sendMessage(input.value);
            }
        });

        chips.addEventListener('click', (event) => {
            const button = event.target.closest('button');
            if (!button) return;
            sendMessage(button.textContent || '');
        });
    })();
</script>
