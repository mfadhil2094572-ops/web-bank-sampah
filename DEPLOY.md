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
