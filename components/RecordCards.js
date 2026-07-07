import { loadingComp } from './loadingSpinner.js';
import { entryGrouper } from '../util/entryGrouper.js';
import { dateSplitter } from '../util/dateSplitter.js';

export function Card(content) {
    
    // let loading = true;

    // if(loading){
    //     attendance.innerHTML = loadingComp();
    // }

    if(content.length === 0){
        return(
            `<div class="flex justify-content-center text-center">
                    <h5 class="fw-semibold mb-0">No Attendance Logs Found</h5>
            </div>`
        );
    }
    
    const groupedLogs = entryGrouper(content);

    return(
       Object.entries(groupedLogs).map(([date, logs]) => (
            `<div class="card border shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-semibold mb-0">${date}</h5>
                </div>

                <div class="card-body">
                    ${logs.map(data => `
                    <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded-3">
                        <div>
                            <small class="text-muted">#${data.id}</small>
                        </div>

                        <div class="d-flex gap-4">
                            <div>
                                <small class="text-muted d-block">Time In</small>
                                <span class="fw-semibold text-success">
                                    ${dateSplitter(data.first_login)}
                                </span>
                            </div>

                            <div>
                                <small class="text-muted d-block">Time Out</small>
                                <span class="fw-semibold text-danger">
                                    ${dateSplitter(data.last_login) ?? '--'}
                                </span>
                            </div>
                        </div>
                    </div>
                `).join('')}
                </div>
                </div>`
        )).join('')
    );
}