import { Dropdown } from './components/Dropdown.js';
import { dateFilterComponent } from './components/dateFilter.js';
import { Button } from './components/Button.js';
import { Card } from './components/RecordCards.js';
import { bindEvents } from './util/bindEvents.js';
import { getSemester } from './api/getSemester.js';
import { getSubjects } from './api/getSubjects.js';

const root = document.getElementById('root');

async function App() {

    let sem = await getSemester();
    let subj = await getSubjects();
    let records = ['Record 1', 'Record 2', 'Record 3'];

    let selectedSem = null;
    let selectedSubj = null;

    root.innerHTML = `
                    <div class="container py-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card p-3 mb-4 shadow-sm">
                                    <div class="row g-3" id="subjectFilter">
                                        ${Dropdown("semester", sem, "Semester", {
                                            valueKey: "prdId",
                                            labelKey: "prdName"
                                        })}
                                        ${Dropdown("subject", subj, "Subject", {
                                            valueKey: "subj_id",
                                            labelKey: "subj_desc",
                                            defaultValue: "Select Subject"
                                        })}
                                        ${Button("Search")}
                                    </div>
                                </div>

                                <div class="card p-3 shadow-sm attendance-card">
                                    <div id="attndnc_logs_card">
                                        <div class="row g-3 mb-3 align-items-end" id="dateFilter">
                                            <div class="col">
                                                ${dateFilterComponent()}
                                            </div>

                                            <div class="col-auto">
                                                ${Button("Filter")}
                                            </div>
                                        </div>
                                            ${Card(records)}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

    bindEvents(root, {
        onChange: (name, value) => {
            if (name === 'semester') selectedSem = value;
            if (name === 'subject') selectedSubj = value;
        },
        onClick: (name) => {
            if (name === 'search') handleSearch(selectedSem, selectedSubj);
        }});
}

function handleSearch(semester, subject) {
    if(!semester || !subject) {
        alert('Please select a Semester and Subject before searching.');
        return;
    }
    alert('Search clicked with Semester: ' + semester + ' and Subject: ' + subject);
}

document.addEventListener('DOMContentLoaded', App);