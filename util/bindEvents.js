export function bindEvents(root, handlers) {
    root.addEventListener('change', (e) => {
        if (!e.target.matches('.dropdown')) return;

        const name = e.target.dataset.name;
        const value = e.target.value;

        handlers.onChange?.(name, value);
    });

    root.addEventListener('click', (e) => {
        if (!e.target.matches('.attdnc')) return;

        const name = e.target.dataset.name;

        handlers.onClick?.(name);
    });
}