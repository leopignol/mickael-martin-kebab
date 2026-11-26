(() => {
    const typeSelect = document.getElementById('apache-log-type');
    const pauseButton = document.getElementById('apache-log-pause');
    const output = document.getElementById('apache-log-output');
    const status = document.getElementById('apache-log-status');
    const state = { log: typeSelect.value, offset: '', generation: '', paused: false, pending: false };

    async function readLog() {
        if (state.paused || state.pending) return;
        state.pending = true;

        const params = new URLSearchParams({ stream: '1', log: state.log });
        if (state.offset !== '') {
            params.set('offset', state.offset);
            params.set('generation', state.generation);
        }

        try {
            const response = await fetch(`pages/logs.php?${params.toString()}`, {
                credentials: 'same-origin',
                cache: 'no-store'
            });
            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || 'Unable to load Apache logs.');
            }

            const wasAtBottom = output.scrollHeight - output.scrollTop - output.clientHeight < 24;
            if (state.offset === '' || state.generation !== result.generation) {
                output.textContent = result.content;
            } else if (result.content) {
                output.textContent += result.content;
            }

            const lines = output.textContent.split('\n');
            if (lines.length > 500) {
                output.textContent = lines.slice(-500).join('\n');
            }
            if (wasAtBottom) output.scrollTop = output.scrollHeight;

            state.offset = String(result.offset);
            state.generation = result.generation;
            status.textContent = `Streaming Apache ${state.log} log · updates every 2 seconds`;
        } catch (error) {
            status.textContent = error instanceof Error ? error.message : 'Unable to load Apache logs.';
        } finally {
            state.pending = false;
        }
    }

    typeSelect.addEventListener('change', () => {
        state.log = typeSelect.value;
        state.offset = '';
        state.generation = '';
        output.textContent = '';
        status.textContent = 'Connecting to the log…';
        readLog();
    });

    pauseButton.addEventListener('click', () => {
        state.paused = !state.paused;
        pauseButton.textContent = state.paused ? 'Resume' : 'Pause';
        pauseButton.setAttribute('aria-pressed', String(state.paused));
        if (!state.paused) readLog();
    });

    readLog();
    window.setInterval(readLog, 2000);
})();
