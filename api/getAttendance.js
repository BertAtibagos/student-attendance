export async function getAttendance(semester, subject) {

    let res = [];
    
    try{ 
        const req = await fetch();
        res = await req.json();
    }catch(error){
        console.error("Error fetching attendance data:", error);
    }
    return res;
}