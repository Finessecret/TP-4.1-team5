let id = null;

async function getDisciplines(){

    let res = await fetch('http://Uschedule/disciplines');
    let disciplines = await res.json();

    document.querySelector('.post-list').innerHTML ='';

    disciplines.forEach((dis) => {
        document.querySelector('.post-list').innerHTML +=`
        <div class = "card">
          <div class="card-body">
            <h5 class="card-name">${dis.name}</h5>
            <a href="#">Подробнее</a>
            <a href="#" onclick="removeDiscipline(${dis.id})">Удалить</a>
            <a href="#" onclick="selectDiscipline(${dis.id}, ${dis.name}">Редактировать</a>
         </div> 
        </div>  
        `
    })
}
async function addDisciplines(){
    const id = document.getElementById('id').value,
        name = document.getElementById('name').value;
    let formData = new FormData();
    formData.append('id', id);
    formData.append('name',name);

    const res = await fetch('http://Uschedule/disciplines', {
        method:'POST',
        body: formData
    })

    const data = await  res.json();

    if(data.status === true){
        await getDisciplines();
    }
}

async function removeDiscipline(id){
    const res = await fetch('http://Uschedule/disciplines/${id}',{
        method:'DELETE'
    })
    const data = await  res.json();

    if(data.status === true){
        await getDisciplines();
    }
}

function selectDiscipline(id,title,body){
    id=id;
    document.getElementById('name').value=name;
}

async function updateDisciplines(){
    const name =  document.getElementById('name').value;

    const data = {
        name: name
    };

    const res = await  fetch(`http://Uschedule/disciplines/${id}`,{
        method: "PATCH",
        body: JSON.stringify(data)
    });


}

getDisciplines();