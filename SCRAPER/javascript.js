function fetchScraper(){
    fetch('http://localhost/SCRAPER/scraper.php')
  .then((response) => response.json())
  .then((json) => {
        json['news'].forEach(element => {
            if(!(element=="Le immagini - Tutti i VIDEO")){
              document.querySelector('.div2').innerHTML+="<p>"+element+"</p>";
            }
            
        });
              
    }
  
  );
}

function getDate(){
  setInterval(() => {
    fetch('http://localhost/SCRAPER/scraper.php')
  .then((response) => response.json())
  .then((json) => {     
            document.querySelector('.div').innerHTML="<p>"+"ORA DI AGGIORNAMENTO: "+json.date+"</p>";
        });
  }, 1000);
  
              
}
