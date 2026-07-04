export function Dropdown(name,content,label,options = {}) {

    const {
        defaultValue = "Select an option",
        valueKey = "id",
        labelKey = "name"
    } = options;

    return `
            <div class="col-md-4">
                <label class="form-label">${label}</label>
                <select class="form-select dropdown" data-name="${name}">
                    <option value="">${defaultValue}</option>
                    ${content.map(item => `
                        <option value="${item[valueKey]}">${item[labelKey]}</option>
                    `).join("")}
                </select>
            </div>`;
}