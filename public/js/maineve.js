const eventar = document.getElementById('event');

if(eventar){
  eventar.addEventListener('click', (e) => {
    if(e.target.className === "btn del"){
      if(confirm('Are you sure?')){
        const id = e.target.getAttribute('data-id');

        fetch(`/event/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
}
