export async function getSubjects(){
    let res = [];

    try{
        const req = await fetch(`controller/subjects.php`);
        res = await req.json();
    }catch(error){
        console.error("Error fetching semester data:", error);
    }

    return res;
}