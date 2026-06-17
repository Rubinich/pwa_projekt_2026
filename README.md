# B.Z. Portal – Web Aplikacija za vijesti
Ovo je responzivna web aplikacija za objavu i administraciju vijesti razvijena u sklopu kolegija _Programiranje web aplikacija_ (PWA).

## Upute za postavljanje i pokretanje projekta
Pratite sljedeće korake kako biste uspješno pokrenuli aplikaciju na svom računalu:

1. Korak: Preuzimanje koda
    - Preuzmite izvorni kod projekta (kao .zip arhivu).
    - Raspakirajte mapu projekta u mapu lokalnog poslužitelja:
    - Ako koristite XAMPP, putanja je: **C:\xampp\htdocs**

2. Korak: Kreiranje i uvoz baze podataka
    - U gornjem izborniku odaberite karticu **Import**
    - Kliknite na gumb **Choose File** i pronađite ```.sql``` datoteku koja se nalazi unutar projekta 
    - Pomaknite se na dno stranice i kliknite gumb **Import**

3. Korak: Provjera konfiguracije povezivanja (PHP)
    - Ukoliko naziv baze podataka, korisničko ime ili lozinka odudaraju od zadanih postavki XAMPP-a, konfiguraciju baze možete provjeriti i promijeniti u datoteci: **database_config/connect.php**
    - Zadane postavke unutar datoteke prilagođene su XAMPP okruženju:
        - Host: ```localhost```
        - Korisnik (Username): ```root```
        - Lozinka (Password): ```""``` (prazno)

4. Korak: Testiranje

## Korisnički računi za testiranje i obranu
Unutar baze podataka ugrađena su dva tipa korisnika:

- Administrator (Razina prava: 1) - omogućuje pristup stranicama **administracija.php**, **unos.php** te izmjenu/brisanje članaka.
    - Korisničko ime: ```zeljeni_username``` (prvi put se potrebno registrirati pomoću forme na stranici **registracija.php** te ručno postaviti razinu prava na 1 u phpMyAdminu)
    - Lozinka: (lozinka koju ste unijeli prilikom registracije)

- Običan korisnik / gost (Razina prava: 0)
    - Može se uspješno prijaviti, ali mu sustav zabranjuje pristup administrativnim dijelovima
    - Račun možete kreirati izravno putem forme na stranici **registracija.php**