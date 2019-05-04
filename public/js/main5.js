const userarr = document.getElementById('user');

if(userarr){
  userarr.addEventListener('click', (e) => {
    if(e.target.className === "btn del"){
      if(confirm('Are you sure?')){
        const id = e.target.getAttribute('data-id');

        fetch(`/users/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
}
