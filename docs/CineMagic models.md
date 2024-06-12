# Models

## [Configuration](/app/Models/Configuration.php)
* [ ] No timestamp
* [ ] No default table name

---

## [Customer](/app/Models/Customer.php)
* [ ] No default Id (`user.id`)
* [ ] No increment Id
* [ ] Has soft delete

Relationships:
| Table                 | Relationship |
| :-------------------- | -----------: |
| [User](#user)         |    BelongsTo |
| [Purchase](#purchase) |      HasMany |
---

## [Genre](/app/Models/Genre.php)
* [ ] No timestamp
* [ ] No default Id (`code`)
* [ ] No increment Id
* [ ] Has soft delete

Relationships:
| Table           | Relationship |
| :-------------- | -----------: |
| [Movie](#movie) |      HasMany |
---

## [Movie](/app/Models/Movie.php)
* [ ] Has soft delete
* [ ] Has Image

Relationships:
| Table                   | Relationship |
| :---------------------- | -----------: |
| [Genre](#genre)         |    BelongsTo |
| [Screening](#screening) |      HasMany |
---

## [Purchase](/app/Models/Purchase.php)
* [ ] Has PDF Image

Relationships:
| Table                 | Relationship |
| :-------------------- | -----------: |
| [Customer](#customer) |       HasOne |
| [Ticket](#ticket)     |      HasMany |
---

## [Screening](/app/Models/Screening.php)

Relationships:
| Table               | Relationship |
| :------------------ | -----------: |
| [Movie](#movie)     |    BelongsTo |
| [Ticket](#ticket)   |      HasMany |
| [Theater](#theater) |    BelongsTo |
---

## [Seat](/app/Models/Seat.php)
* [ ] No timestamp
* [ ] Has soft delete

Relationships:
| Table               | Relationship |
| :------------------ | -----------: |
| [Ticket](#ticket)   |      HasMany |
| [Theater](#theater) |    BelongsTo |
---

## [Theater](/app/Models/Theater.php)
* [ ] No timestamp
* [ ] Has soft delete
* [ ] Has Image

Relationships:
| Table                   | Relationship |
| :---------------------- | -----------: |
| [Screening](#screening) |      HasMany |
| [Seat](#seat)           |      HasMany |
---

## [Ticket](/app/Models/Ticket.php)

Relationships:
| Table                   | Relationship |
| :---------------------- | -----------: |
| [Purchase](#purchase)   |    BelongsTo |
| [Seat](#seat)           |    BelongsTo |
| [Screening](#screening) |    BelongsTo |
---

## [User](/app/Models/User.php)
* [ ] Has soft delete
* [ ] Has Image

Relationships:

| Table    | Relationship |
| :------- | -----------: |
| Customer |       HasOne |
