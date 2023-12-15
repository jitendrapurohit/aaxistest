# TechLadd Assignment Aaxistest

## Requirements

- Docker
- Symfony CLI

## Installation

- Execute `docker-compose up -d`.
- Execute the migration to setup database table using `docker-compose exec php php bin/console doctrine:migrations:migrate`

## Testing

- Import `TechLadd Testing.postman_collection.json` collection file into postman.
- Test `Load`, `Update` & `List` endpoint implementation.

## Assumptions

I made the following assumptions on token generation since there isn't an actual user available in the project.

Example JWT token used for authentication is:

```json
eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MDI2NTA0MDEsImV4cCI6MTcwMjY1NDAwMSwicm9sZXMiOlsiUk9MRV9VU0VSIiwiSVNfQVVUSEVOVElDQVRFRF9GVUxMWSJdLCJ1c2VybmFtZSI6ImRlbW8ifQ.f_Kp3QmCNxMTZpVXNhEJtAS0dY8TZ8oEA5vP_3PmbIUZ7Ei743j-9VzwiDdUemR6mE-2-z-ZMa2EQoH6VtKYDsxdTzo_QDCZvZxKp4EXZ3IQI47wp0vKRVQ4HIV7ZOD2OJQtPmGF6SF4s9qxYAKG9oQkbZ_bySDrZpGhceKSnuarFHYKU-wZ35To1BgjZkg2YN_4AgTGrGD0P5jMoDAVAIQYDrIQvZ_w5J3byiFOkQfcVGM3s--N8cz9e30Y4yK2e7J62r-F5I-3yK8Hgp7ZgduBR_osajmTNnfZ7R_HalFODUQvujUuV4M7oSGSunloxstOR6vcyGr9dzlOk3_7VZQqsk9lQyb724Ux--RvQWcTO7CwUQpMJwkwKzuD8ik7SV7FILj_l9vIBjfldHUelhinK0oo0HZbt5oQKlhaKyThGhULlSh3yelMk10oCcym9YnI16Vp-l225q6yd16usdkOKMvOiOXim3yEgEwD6eI8_xR0PzuxfjfCw_TcsT2B3W-I57R3PKYtm7uaaIH2Lw1wQBp64KBRAlkDiC-umOxeL1bDKuYw_17-jlDf1cadZ1-2jE3Vzg4JHqNyZnuxl8QpOBG_3jXRX2lPIfgYFNiuUJrbpU1Az8NRBMtc8nKnw_GXqBgetPSJkDQF-DndY1M8lYvDtGQwm4TIFmqRXtI
```
- All test are done in postman using the above Bearer token.

