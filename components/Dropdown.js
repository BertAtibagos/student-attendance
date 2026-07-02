export function Dropdown(name,content,defaultValue = "Select an option") {
    return `
            <select data-name="${name}" class="dropdown">
                <option value="" disabled selected>${defaultValue}</option>
                ${content.map((s) => 
                        `<option value="${s}">${s}</option>`
                    ).join('')}
            </select>`;
}