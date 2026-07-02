import { Dropdown } from './components/Dropdown.js';
import { Button } from './components/Button.js';
import { bindEvents } from './util/bindEvents.js';

const root = document.getElementById('root');

function App() {

    let sem = ['Spring', 'Summer', 'Fall'];
    let subj = ['Math', 'English', 'Science'];

    root.innerHTML = `
        ${Dropdown("semester", sem, "Select Semester")}
        ${Dropdown("subject", subj, "Select Subject")}
        ${Button("Search")}
    `;
    bindEvents(root, {onChange: (name, value) => {
            if (name === 'semester') handleSemesterChange(value);
            if (name === 'subject') handleSubjectChange(value);
        },
        onClick: (name) => {
            if (name === 'search') handleSearch();
        }});
}

function handleSemesterChange(value){
    console.log('Selected Semester:', value);
}

function handleSubjectChange(value){
    console.log('Selected Subject:', value);
}

function handleSearch(){
    alert('Search button clicked');
}

document.addEventListener('DOMContentLoaded', App);