const LINK_PATTERNS = [
    { pattern: /#iletisim\b/gi, href: '/iletisim', label: 'iletişim formu' },
    { pattern: /\/iletisim\b/gi, href: '/iletisim', label: 'iletişim formu' },
    { pattern: /#hizmetler\b/gi, href: '/hizmetler', label: 'hizmetlerimiz' },
    { pattern: /\/hizmetler\b/gi, href: '/hizmetler', label: 'hizmetlerimiz' },
    { pattern: /#vaka-calismalari\b/gi, href: '/vaka-calismalari', label: 'vaka çalışmaları' },
    {
        pattern: /\/vaka-calismalari\b/gi,
        href: '/vaka-calismalari',
        label: 'vaka çalışmaları',
    },
];

/**
 * @param {string} content
 * @returns {Array<{ type: 'text' | 'link', text?: string, href?: string, label?: string }>}
 */
export function parseChatMessage(content) {
    if (!content) {
        return [{ type: 'text', text: '' }];
    }

    let normalized = content;

    LINK_PATTERNS.forEach(({ pattern, href, label }) => {
        normalized = normalized.replace(pattern, `⟦LINK:${href}:${label}⟧`);
    });

    const parts = normalized.split(/⟦LINK:([^⟧]+):([^⟧]+)⟧/);
    const segments = [];

    for (let i = 0; i < parts.length; i += 3) {
        if (parts[i]) {
            segments.push({ type: 'text', text: parts[i] });
        }

        if (parts[i + 1]) {
            segments.push({
                type: 'link',
                href: parts[i + 1],
                label: parts[i + 2] ?? 'buraya tıklayın',
            });
        }
    }

    return segments.length > 0 ? segments : [{ type: 'text', text: content }];
}
