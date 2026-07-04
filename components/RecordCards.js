export function Card(content) {
    
    return content.map((item) => (
        `<div class="card">
            <p>${item}</p>
        </div>`
    )).join('');
}