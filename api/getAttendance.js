export async function getAttendance(semester, subject) {

    let res = [];
    
    try{ 

        const params = new URLSearchParams({
            semester: semester,
            subject: subject
        });

        const req = await fetch(`controller/attendance.php`,{
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: params
        });
        
        res = await req.json();
    }catch(error){
        console.error("Error fetching attendance data:", error);
    }
    return res;
}