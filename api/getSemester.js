export async function getSemester() {

    let res = [];

    try{
        const req = await fetch(`controller/semester.php`);
        res = await req.json();
    }catch(error){
        console.error("Error fetching semester data:", error);
    }

    return res;
}