Containerized deploy & Codespaces
================================

This repository includes a `Dockerfile`, a `.devcontainer` config for Codespaces, and a GitHub Actions workflow to build and push a Docker image to GitHub Container Registry (GHCR).

Run locally with Docker
-----------------------

Build image:

```bash
docker build -t web-bank-sampah .
```

Run container (mount local sqlite DB):

Linux / macOS:

```bash
docker run --rm -p 8000:80 -v "$(pwd)/database/database.sqlite:/var/www/html/database/database.sqlite" web-bank-sampah
```

Windows PowerShell:

```powershell
docker run --rm -p 8000:80 -v "${PWD}\database\database.sqlite:/var/www/html/database/database.sqlite" web-bank-sampah
```

Codespaces / Devcontainer
-------------------------

Open this repository in GitHub Codespaces or use VS Code Remote - Containers. The `.devcontainer/devcontainer.json` points to the included `Dockerfile` and forwards ports `8000` and `80`.

CI / GHCR
---------

The workflow `.github/workflows/build-and-push-backend.yml` builds the Docker image on pushes to `main`/`master` and pushes to GHCR at `ghcr.io/<owner>/<repo>:latest`.

Notes
-----
- If you want to deploy the frontend as pure static (e.g., GitHub Pages), you can host the `public` folder statically, but the backend must remain accessible as a separate service (the app uses PHP for dynamic features and DB access).
- To deploy a full production service, run the container on a server (VPS, Cloud Run, Render, Fly.io, etc.) and attach a managed DB if you prefer MySQL/Postgres.

Render deployment steps
1. Create a Render account and create a new Web Service (Docker).
2. Take note of the `Service ID` for the service.
3. In your GitHub repository, add the following repository secrets:
	- `RENDER_API_KEY` — your Render API key
	- `RENDER_SERVICE_ID` — the service ID from Render
	- `DB_DRIVER`, `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` — database credentials for the managed DB (if using Render-managed MySQL)
4. (Optional) After creating a managed database on Render, run the `Seed Database` workflow in GitHub Actions (Actions → Seed Database → Run workflow) to apply schema and seed initial data.

Notes
- GitHub Actions workflow `render-deploy.yml` will trigger a Render deploy when pushing to `main` if the Render secrets are present.
- The `seed-db.yml` workflow can be run manually to execute `database/bank_sampah.sql` and seeders. Ensure DB secrets are configured in GitHub Secrets.
