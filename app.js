import { Dropdown } from './components/Dropdown.js';
import { Button } from './components/Button.js';
import { bindEvents } from './util/bindEvents.js';
import { Card } from './components/RecordCards.js';
import { getSemester } from './api/getSemester.js';

const root = document.getElementById('root');

function App() {

    const session = window.__SESSION__;

    let sem = getSemester();
    let subj = ['Math', 'English', 'Science'];
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
                                        ${Dropdown("subject", subj, "Subject", "Select Subject")}
                                        ${Button("Search")}
                                    </div>
                                </div>

                                <div class="card p-3 shadow-sm attendance-card">
                                    <div id="attndnc_logs_card">
                                        ${Card(records)}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    `;

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