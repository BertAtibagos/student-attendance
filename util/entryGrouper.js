export function entryGrouper(logs) {
    return logs.reduce((groups, log) => {
        const date = log.log_date;
        if (!groups[date]) {
            groups[date] = [];
        }
        groups[date].push(log);
        return groups;
    }, {});
}