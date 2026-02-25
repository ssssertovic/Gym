# GymApp

**GymApp** je web aplikacija za upravljanje teretanom razvijena u **Laravel** okruženju s **MySQL** bazom podataka. Aplikacija rješava potrebu teretane da centralizuje članstvo, planove, trenere i rezervacije termina, dok registrovani korisnici mogu pregledati planove, birati trenere, zakazivati treninge i upravljati vlastitim profilom. Uloga administratora omogućava potpunu kontrolu nad sadržajem i korisnicima sistema.

---

## Sadržaj

1. [Pregled funkcionalnosti](#pregled-funkcionalnosti)
2. [Tehnologije i arhitektura](#tehnologije-i-arhitektura)
3. [Baza podataka](#baza-podataka)
4. [REST API integracija](#rest-api-integracija)
5. [Instalacija i pokretanje (lokalno)](#instalacija-i-pokretanje-lokalno)
6. [Testiranje](#testiranje)
7. [Struktura projekta](#struktura-projekta)
8. [Sigurnost](#sigurnost)
9. [Moguća poboljšanja](#moguća-poboljšanja)
10. [Autor](#autor)

---

## Pregled funkcionalnosti

Funkcionalnosti su podijeljene prema ulogama: **registrovani korisnik** i **administrator**.

### Registrovani korisnik

<p align="center">
  <img src="images/dashboard.png" width="700">
</p>

- **Registracija i prijava** — Registracija putem e-maila i lozinke, verifikacija e-maila (Laravel Jetstream), prijava i odjava. Podržana je i opcija dvofaktorske autentifikacije.

<p align="center">
  <img src="docs/images/registration.png" width="700">
</p>

<p align="center">
  <img src="docs/images/login.png" width="700">
</p>

- **Pregled planova** — Lista svih planova članstva s detaljima (naziv, cijena, trajanje, opis) i mogućnost pregleda pojedinačnog plana.

<p align="center">
  <img src="docs/images/plans.png" width="700">
</p>

- **Pregled trenera** — Lista trenera s podacima (ime, prezime, nivo, opis) i pregled profila pojedinačnog trenera.

<p align="center">
  <img src="docs/images/trainers.png" width="700">
</p>

- **Zakazivanje termina** — Kreiranje rezervacije treninga: izbor plana, trenera i datuma/vremena; unos opcionih napomena. Korisnik vidi samo svoje rezervacije.

<p align="center">
  <img src="docs/images/booking.png" width="700">
</p>

- **Upravljanje profilom** — Ažuriranje imena, e-maila, visine (cm) i težine (kg); promjena lozinke; upload profilne fotografije (Laravel Jetstream); brisanje vlastitog računa (potvrda lozinkom).

<p align="center">
  <img src="docs/images/profile-management.png" width="700">
</p>

### Administrator

- **Upravljanje korisnicima (članovima)** — Lista svih korisnika s ulogom „član” (user), dodavanje novog člana (ime, e-mail, lozinka, visina, težina), uređivanje i brisanje članova. Dostupno je i dodavanje fajlova po članu (modul „file add” / `member_files`).
- **Upravljanje trenerima** — CRUD operacije nad trenerima (dodavanje, uređivanje, brisanje).
- **Upravljanje planovima** — CRUD operacije nad planovima članstva (naziv, cijena, trajanje, opis).
- **Upravljanje treningima (workouts)** — Pregled treninga, dodavanje novih i brisanje. Tabela `workouts` vodi evidenciju treninga (datum, ocjena, opis, trener, član).
- **Pregled rezervacija** — Administrator na stranici „Rezervacije” vidi sve rezervacije u sustavu (s imenom korisnika, planom i trenerom); običan korisnik vidi samo svoje rezervacije.

Dashboard za administratora prikazuje i kratku statistiku: broj članova (iz tabele `members`), broj planova, broj trenera i broj treninga.

---

## Tehnologije i arhitektura

- **Backend:** PHP 7.3+ / 8.0+, Laravel 8.x  
- **Baza podataka:** MySQL  
- **Frontend:** Laravel Blade predlošci, Laravel Livewire, Alpine.js, Tailwind CSS; Laravel Mix za kompilaciju CSS/JS  
- **Autentifikacija:** Laravel Jetstream (Fortify), Laravel Sanctum  
- **HTTP klijent (server-side):** Guzzle (korišten u proxy-ju za eksterni API)

### MVC u kontekstu projekta

Aplikacija prati **MVC (Model–View–Controller)** arhitekturu:

- **Modeli** (`app/Models`) predstavljaju entitete iz baze: `User`, `Booking`, `Plan`, `Trainer`, `Member`, `Workout`. Odgovorni su za strukturu podataka, validaciju na razini atributa i odnose između tabela (npr. `Booking` pripada `User`, `Plan` i `Trainer`). Ne sadrže poslovnu logiku za HTTP zahtjeve.
- **Kontroleri** (`app/Http/Controllers`) obrađuju zahtjeve korisnika: primaju input, pozivaju modele ili upite nad bazom, primjenjuju validaciju (npr. `BookingController::store` za kreiranje rezervacije) i vraćaju odgovor — najčešće redirect na rutu s porukom ili prikaz view-a s podacima (npr. `PlanController::index`, `BookingController::index`).
- **Pogledi (Views)** (`resources/views`) su Blade predlošci koji prikazuju HTML: dashboard, liste planova/trenera/rezervacija, forme za zakazivanje, admin stranice za članove, planove, trenere i treninge. Koriste se komponente (npr. Jetstream `x-app-layout`, `x-jet-input`) i na dashboardu inline JavaScript za dohvat motivacionih citata (fetch).

Tako se zahtjev prvo usmjerava u odgovarajući kontroler (preko `routes/web.php`), kontroler koristi modele za čitanje/pisanje, a rezultat se prikazuje u view-u.

### ORM (Eloquent) i mapiranje tabela

**Eloquent ORM** mapira tabele u bazi na PHP klase (modele). Umjesto pisanja sirovih SQL upita, aplikacija koristi metode na modelima i njihovim odnosima:

- **users** — model `User`; polja kao `name`, `email`, `password`, `role`, `height_cm`, `weight_kg`, `profile_photo_path`. Odnosi: `User` ima više rezervacija (`hasMany(Booking)`), jednu „najnoviju” rezervaciju (`hasOne` latest booking).
- **bookings** — model `Booking`; polja `user_id`, `plan_id`, `trainer_id`, `scheduled_at`, `notes`. Svaka rezervacija pripada jednom korisniku, jednom planu i jednom treneru (`belongsTo` User, Plan, Trainer). Kreiranje rezervacije: `Booking::create([...])` u `BookingController::store`.
- **plans** — model `Plan`; polja `name`, `price`, `duration_days`, `description`.
- **trainers** — model `Trainer`; polja `name`, `lastname`, `level`, `description`.
- **members** — model `Member`; zasebna tabela (npr. za dodatnu evidenciju); u admin dijelu se „članovi” u smislu korisnika prikazuju preko `User::where('role', 'user')`.
- **workouts** — model `Workout`; polja `date`, `grade`, `description`, `trainer`, `member`.

Gdje je potrebno, u kontrolerima se koristi i `DB::table(...)` za složenije join upite (npr. lista rezervacija s imenima korisnika, planova i trenera).

---

## Baza podataka

### Glavne tabele

| Tabela       | Opis |
|-------------|------|
| **users**   | Korisnici aplikacije: `name`, `email`, `password`, `role` (user/admin), `height_cm`, `weight_kg`, `profile_photo_path`, `email_verified_at`, timestamps. Laravel Jetstream/Fortify koriste ovu tabelu za prijavu i profil. |
| **plans**   | Planovi članstva: `name`, `price`, `duration_days`, `description`. |
| **trainers**| Treneri: `name`, `lastname`, `level`, `description`, timestamps. |
| **bookings**| Rezervacije treninga: `user_id` (FK → users), `plan_id` (FK → plans), `trainer_id` (FK → trainers), `scheduled_at`, `notes`, timestamps. Cascade on delete na stranim ključevima. |
| **workouts**| Evidencija treninga: `date`, `grade`, `description`, `trainer`, `member`. |
| **members** | Tabela članova (dodatna evidencija): npr. `name`, `year`, `plan`, `height_cm`, `body_fat_percentage`, `photo_path` itd. |

### Pomoćne / sistemske tabele

- **sessions** — Laravel sesije (session driver `database`): `id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`.
- **password_resets**, **failed_jobs**, **personal_access_tokens** — standardne Laravel tabele za reset lozinke, failed jobs i Sanctum tokene.
- **member_files** — pohrana fajlova po članu (povezana s admin modulom za članove).

### Ključni odnosi

- **bookings** → `user_id` → **users** (jedan korisnik ima više rezervacija).
- **bookings** → `plan_id` → **plans** (jedna rezervacija jedan plan).
- **bookings** → `trainer_id` → **trainers** (jedna rezervacija jedan trener).
- U Eloquentu: `User::hasMany(Booking)`, `Booking::belongsTo(User|Plan|Trainer)`.

---

## REST API integracija

<p align="center">
  <img src="docs/images/rest-api.png" width="700">
</p>

Aplikacija **koristi eksterni REST API** za motivacione citate. Na dashboardu se prikazuje sekcija „Dnevna motivacija” koja periodično (npr. svakih 30 sekundi) dohvaća novi citat.

- **Eksterni API:** ZenQuotes (`https://zenquotes.io/api/random`) — na serveru se poziva putem Laravel HTTP klijenta (Guzzle) u `QuoteController`. Server djeluje kao **proxy** kako bi se izbjegao CORS pri direktnom pozivu iz preglednika.
- **Korisnički endpoint:** `GET /quote` — vraća JSON u formatu `{ "text": "...", "author": "..." }`. Na frontendu se u dashboard view-u koristi **Fetch API** (`fetch('/quote')`), odgovor se parsira kao JSON i prikazuje u DOM-u. U slučaju greške (npr. neuspjeh poziva ili prazan odgovor) koristi se **fallback** poruka (npr. „Snaga dolazi iz upornosti. Nastavi dalje.” — autor „Astra Fit”).
- **Testiranje:** U pregledniku (Chrome/Edge) otvoriti Developer Tools → Network. Osvježiti dashboard ili pričekati periodični dohvat. Filtrirati zahtjeve prema „quote” ili URL-u `/quote`. Provjeriti: **status 200**, tip odgovora **JSON**, te da tijelo odgovora sadrži `text` i `author`. Pri isključenom eksternom API-ju ili mrežnoj grešci očekivati fallback (poruka i dalje prikazana, status 200 od našeg endpointa).

---

## Instalacija i pokretanje (lokalno)

### Preduslovi

- PHP ≥ 7.3 ili 8.0 (proširenja: npr. `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `curl`)
- Composer
- Node.js i npm (projekt koristi Laravel Mix i Tailwind)
- MySQL 

### Koraci

1. **Kloniranje repozitorija**
   ```bash
   git clone https://github.com/ssssertovic/GymApp.git
   cd GymApp
   ```

2. **Instalacija PHP zavisnosti**
   ```bash
   composer install
   ```

3. **Konfiguracija okruženja**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   U `.env` postaviti bazu podataka:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gym
   DB_USERNAME=root
   DB_PASSWORD=lozinka
   ```
   Postaviti i `APP_URL` na lokalnu adresu (npr. `http://localhost:8000`) radi ispravnog rada sesija i CSRF zaštite.

4. **Kreiranje baze**
   Kreirati praznu MySQL bazu (npr. ime `gym` kao u `DB_DATABASE`).

5. **Migracije (i opciono seed)**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
   (Seed koristiti ako postoje seederi za početne podatke.)

6. **Frontend (npm)**
   ```bash
   npm install
   npm run dev
   ```
   Za produkciju: `npm run production`.

7. **Pokretanje servera**
   ```bash
   php artisan serve
   ```
   Aplikacija je dostupna na npr. `http://localhost:8000`.

Za testiranje admin funkcija potrebno je korisniku u tabeli `users` postaviti `role = 'admin'` (npr. ručno u bazi ili putem seedera).

---

## Testiranje

- **CRUD i tok kroz aplikaciju:** Svi glavni tokovi testirani su kroz korisničko sučelje: registracija, prijava, pregled planova i trenera, kreiranje rezervacije, ažuriranje profila (ime, email, visina, težina, lozinka, slika), brisanje računa. Za admina: dodavanje/uređivanje/brisanje članova (korisnika), planova, trenera i treninga, te pregled svih rezervacija. Rezultati su provjeravani u **MySQL Workbench** ili **phpMyAdmin** — provjera unosa u tabelama `users`, `bookings`, `plans`, `trainers`, `workouts` itd.
- **Validacija:** Testirane su situacije kao što su duplikat e-maila pri registraciji ili ažuriranju člana, neispravan unos (npr. obavezna polja prazna), te za rezervacije pravilo `scheduled_at` mora biti u budućnosti (`after:now`). Poruke o greškama prikazuju se korisniku (npr. Jetstream validation errors, Laravel `$request->validate(...)`).
- **API citata:** Provjera preko Browser DevTools (Network): status 200, JSON odgovor, prikaz fallback poruke kada eksterni API nije dostupan ili vraća neispravan odgovor.

Automatski testovi (npr. PHPUnit) mogu se pokrenuti naredbom `php artisan test` ili `./vendor/bin/phpunit` ako su napisani (npr. `tests/Feature/DeleteAccountTest.php` za brisanje računa).

---

## Struktura projekta

- **routes/** — Definicija ruta. `web.php` sadrži sve web rute: zaštićene `auth:sanctum, verified` grupe, rute za dashboard, quote, planove, trenere, rezervacije, te grupu za admina (`role:admin`) — članovi, planovi, treneri, treningi.
- **app/Models/** — Eloquent modeli: `User`, `Booking`, `Plan`, `Trainer`, `Member`, `Workout`, `MemberFile`.
- **app/Http/Controllers/** — Kontroleri: `PlanController`, `TrainerWebController`, `BookingController`, `MemberController`, `WorkoutController`, `QuoteController`.
- **app/Http/Middleware/** — `EnsureRole` (provjera uloge, npr. `role:admin`) i ostali Laravel/Jetstream middleware-i.
- **resources/views/** — Blade predlošci: `dashboard`, `plans` (index, show, add, edit), `trainers` (index, show, add, edit), `bookings` (index, create), `members` (index, add, edit, file_add), `workouts` (index, add), `profile` (show, update form, password, delete user), `auth` (login, register, forgot-password, itd.), `layouts` (app, guest).
- **database/migrations/** — Migracije za tabele: `users`, `sessions`, `plans`, `trainers`, `bookings`, `workouts`, `members`, `member_files`, te alter migracije (role na users, fitness polja, photo_path, itd.).
- **database/seeders/** — Seederi za početne podatke (ako postoje, npr. `DemoMembersSeeder`, `MemberTableSeeder`).
- Važne datoteke: `routes/web.php` (sve web rute), `.env` (konfiguracija okruženja i baze), `composer.json` / `package.json` (zavisnosti).

---

## Sigurnost

- **Lozinke:** Hashiranje putem Laravel bcrypt (npr. `Hash::make()` pri registraciji i ažuriranju lozinke).
- **Validacija:** Ulaz u kontrolerima validiran putem `$request->validate(...)` (npr. obavezna polja, `exists:plans,id`, `email|unique:users`, `after:now` za datum rezervacije).
- **Autentifikacija i autorizacija:** Zaštićene rute zahtijevaju prijavu (`auth:sanctum`, `verified`). Admin rute zahtijevaju ulogu admin (`middleware('role:admin')`), implementirano u `EnsureRole` middleware-u koji provjerava `Auth::user()->role`. Pristup tuđim resursima ograničen (npr. korisnik vidi samo svoje rezervacije; brisanje „člana” dozvoljeno samo za korisnike s ulogom user).
- **CSRF:** Laravel CSRF zaštita za sve state-changing POST zahtjeve; sesija i cookie konfigurirani u `.env` (npr. `SESSION_DRIVER=file`).

---

## Moguća poboljšanja

- **Obavještenja** — E-mail ili in-app obavijesti korisniku pri kreiranoj rezervaciji ili podsjetnik dan prije termina.
- **Statistika i izvještaji** — Detaljniji admin dashboard: grafovi posjećenosti, prihodi po planu, najzauzetiji treneri.
- **Kalendarski prikaz** — Prikaz rezervacija u kalendarskom view-u (dan/tjedan) za lakši pregled i izbor termina.
- **Upravljanje rasporedom** — Ograničenje broja rezervacija po terminu, provjera dostupnosti trenera, blokiranje termina.
- **Ocjene i komentari** — Mogućnost ocjenjivanja trenera ili treninga nakon odrađene sesije.
- **PDF izvještaji** — Export liste članova ili rezervacija u PDF.
- **API dokumentacija** — Dokumentirati endpoint `/quote` i eventualne buduće API rute za mobilnu ili vanjsku integraciju.

---

## Autor

**GymApp** — Projekat izrađen u sklopu predmeta Objektno orijentirane baze podataka na Tehnički fakultet Bihać.

**Akademska godina:** 2025/2026 

**Autor:** Sarah Šertović, 1250


---

