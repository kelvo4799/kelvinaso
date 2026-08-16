@php
    $enabled = \App\Models\Settings::where('key', 'enable_ai_chatbot')->value('value') ?? '1';
@endphp

@if ($enabled === '1')
    <div id="aiChatbotContainer" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; font-family: var(--font-sans);">
        <!-- Toggle Button -->
        <button type="button" id="btnToggleChatbot" onclick="toggleChatbotWindow()" style="width: 54px; height: 54px; border-radius: 50%; background: var(--accent); color: #fff; border: none; box-shadow: var(--glow), 0 8px 24px rgba(0,0,0,0.25); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: transform 0.2s ease;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </button>

        <!-- Chat Window -->
        <div id="chatbotWindow" style="display: none; position: absolute; bottom: 70px; right: 0; width: 370px; height: 500px; background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); flex-direction: column; overflow: hidden;">
            <!-- Header -->
            <div style="background: var(--accent); color: #fff; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 8px; height: 8px; border-radius: 50%; background: #34d399;"></div>
                    <span style="font-weight: 700; font-size: 0.95rem;">Kelvin's Sales & AI Assistant</span>
                </div>
                <button type="button" onclick="toggleChatbotWindow()" style="background: none; border: none; color: #fff; cursor: pointer; font-size: 1.2rem; line-height: 1;">&times;</button>
            </div>

            <!-- Messages Body -->
            <div id="chatbotMessages" style="flex: 1; padding: 16px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; font-size: 0.875rem; background: var(--bg);">
                <div style="background: var(--card); border: 1px solid var(--border); padding: 12px 14px; border-radius: 12px; max-width: 85%; align-self: flex-start; color: var(--fg); line-height: 1.5;">
                    👋 Hi there! I'm Kelvin's AI Portfolio & Sales Assistant. Tell me briefly what you're looking to build or ask any questions about Kelvin's work!
                </div>
            </div>

            <!-- Quick Action Prompt Pills -->
            <div style="padding: 6px 12px; background: var(--bg-2); border-top: 1px solid var(--border); display: flex; gap: 6px; overflow-x: auto; white-space: nowrap;">
                <button type="button" onclick="quickPrompt('I need a website built for my business')" style="font-size: 0.725rem; padding: 4px 10px; border-radius: 12px; border: 1px solid var(--border); background: var(--card); color: var(--fg); cursor: pointer;">
                    🚀 I need a project built
                </button>
                <button type="button" onclick="quickPrompt('What tech stacks does Kelvin use?')" style="font-size: 0.725rem; padding: 4px 10px; border-radius: 12px; border: 1px solid var(--border); background: var(--card); color: var(--fg); cursor: pointer;">
                    🛠️ Tech Stack
                </button>
                <button type="button" onclick="quickPrompt('Is Kelvin available for hire?')" style="font-size: 0.725rem; padding: 4px 10px; border-radius: 12px; border: 1px solid var(--border); background: var(--card); color: var(--fg); cursor: pointer;">
                    💼 Availability
                </button>
            </div>

            <!-- Input Form -->
            <form onsubmit="sendChatbotMessage(event)" style="padding: 12px; border-top: 1px solid var(--border); background: var(--bg-2); display: flex; gap: 8px;">
                <input type="text" id="chatbotInput" placeholder="Ask a question or describe your project..." required style="flex: 1; padding: 8px 12px; border-radius: 20px; border: 1px solid var(--border); background: var(--bg); color: var(--fg); font-size: 0.85rem; outline: none;" />
                <button type="submit" id="btnChatSend" style="background: var(--accent); color: #fff; border: none; padding: 8px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">Send</button>
            </form>
        </div>
    </div>

    <script>
        let chatLoaded = false;

        function toggleChatbotWindow() {
            const win = document.getElementById('chatbotWindow');
            if (!win) return;
            const isHidden = (win.style.display === 'none' || win.style.display === '');
            win.style.display = isHidden ? 'flex' : 'none';

            if (isHidden && !chatLoaded) {
                loadChatHistory();
            }
        }

        async function loadChatHistory() {
            try {
                const res = await fetch('{{ route("ai-chatbot.history") }}');
                const data = await res.json();
                if (data.messages && data.messages.length > 0) {
                    const container = document.getElementById('chatbotMessages');
                    data.messages.forEach(msg => {
                        const bubble = document.createElement('div');
                        if (msg.sender === 'user') {
                            bubble.style.cssText = 'background: var(--accent); color: #fff; padding: 10px 14px; border-radius: 12px; max-width: 85%; align-self: flex-end;';
                        } else {
                            bubble.style.cssText = 'background: var(--card); border: 1px solid var(--border); padding: 10px 14px; border-radius: 12px; max-width: 85%; align-self: flex-start; color: var(--fg); line-height: 1.5;';
                        }
                        bubble.innerText = msg.message;
                        container.appendChild(bubble);
                    });
                    container.scrollTop = container.scrollHeight;
                }
                chatLoaded = true;
            } catch (e) {
                console.error('History load failed', e);
            }
        }

        function quickPrompt(text) {
            const input = document.getElementById('chatbotInput');
            input.value = text;
            sendChatbotMessage(new Event('submit'));
        }

        async function sendChatbotMessage(e) {
            e.preventDefault();
            const input = document.getElementById('chatbotInput');
            const container = document.getElementById('chatbotMessages');
            const btn = document.getElementById('btnChatSend');
            const msg = input.value.trim();

            if (!msg) return;

            // Render Visitor Message
            const userBubble = document.createElement('div');
            userBubble.style.cssText = 'background: var(--accent); color: #fff; padding: 10px 14px; border-radius: 12px; max-width: 85%; align-self: flex-end;';
            userBubble.innerText = msg;
            container.appendChild(userBubble);
            input.value = '';
            container.scrollTop = container.scrollHeight;

            // Render Typing Indicator
            const typingBubble = document.createElement('div');
            typingBubble.style.cssText = 'background: var(--card); border: 1px solid var(--border); padding: 10px 14px; border-radius: 12px; max-width: 85%; align-self: flex-start; color: var(--muted); font-style: italic;';
            typingBubble.innerText = '✨ AI Assistant is typing...';
            container.appendChild(typingBubble);
            container.scrollTop = container.scrollHeight;

            btn.disabled = true;

            try {
                const response = await fetch('{{ route("ai-chatbot.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: msg })
                });

                const data = await response.json();
                container.removeChild(typingBubble);

                const aiBubble = document.createElement('div');
                aiBubble.style.cssText = 'background: var(--card); border: 1px solid var(--border); padding: 10px 14px; border-radius: 12px; max-width: 85%; align-self: flex-start; color: var(--fg); line-height: 1.5;';
                aiBubble.innerText = data.reply || "I'm here to help! Ask me anything about Kelvin's work or your project.";
                container.appendChild(aiBubble);
            } catch (err) {
                container.removeChild(typingBubble);
                const errBubble = document.createElement('div');
                errBubble.style.cssText = 'background: rgba(239, 68, 68, 0.1); color: #f87171; padding: 10px 14px; border-radius: 12px; max-width: 85%; align-self: flex-start;';
                errBubble.innerText = "I'm having a little trouble connecting right now. Please try again in a moment or leave Kelvin a direct message on the contact page!";
                container.appendChild(errBubble);
            } finally {
                btn.disabled = false;
                container.scrollTop = container.scrollHeight;
            }
        }
    </script>
@endif
