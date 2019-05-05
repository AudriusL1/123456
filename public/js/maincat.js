const catar = document.getElementById('category');

if(catar){
  catar.addEventListener('click', (e) => {
    if(e.target.className === "btn del"){
      if(confirm('Are you sure?')){
        const id = e.target.getAttribute('data-id');

        fetch(`/categories/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
}
