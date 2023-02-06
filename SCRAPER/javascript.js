
function fetchScraper(){
    fetch('http://localhost/SCRAPER/scraper.php')
  .then((response) => response.json())
  .then((json) => {
        json['news'].forEach(element => {
            document.querySelector('.div').innerHTML+="<p>"+element+"</p>";
        });
            
        
    }
  
  );
}
