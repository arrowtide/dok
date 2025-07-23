document.addEventListener('alpine:init', function(event) {
    Alpine.data('copyCode', () => ({
        open: false,
        text: 'Copy',
        copied: 'false',

        async writeToClipboard() {
            const el = this.$el;

            try {
                let text = el.closest('pre').querySelector('code').innerText;

                await navigator.clipboard.writeText(text);

                this.copied = 'true';
                this.text = 'Copied';

            } catch (error) {
                this.copied = 'error';
                this.text = 'Error, could not copy to clipboard.';

                el.classList.add('animate-shake');

                console.error(error.message);

            } finally {
                setTimeout(() => {
                    this.copied = 'false';
                    this.text = 'Copy';

                    el.classList.remove('animate-shake');
                }, 1250)
            }
        },

        eventListeners: {
            [`@click`](event) {
                this.writeToClipboard();
            },
        }
    }));
});
