param(
    [string]$PublicDir = "$PSScriptRoot\\..\\public",
    [string]$OutDir = "$PSScriptRoot\\..\\docs",
    [string]$RepoName = 'web-bank-sampah'
)

Write-Output "Building static site from: $PublicDir -> $OutDir"
if (-Not (Test-Path $PublicDir)) { Write-Error "Public directory not found: $PublicDir"; exit 1 }

# Normalize paths
$projectRoot = (Resolve-Path (Join-Path $PSScriptRoot '..')).ProviderPath
$pubPath = (Resolve-Path $PublicDir).ProviderPath
$outPath = Join-Path $projectRoot 'docs'
if (Test-Path $outPath) { Remove-Item -Recurse -Force $outPath }
New-Item -ItemType Directory -Path $outPath | Out-Null

# Copy assets folder if present
$assetSrc = Join-Path $PublicDir 'assets'
if (Test-Path $assetSrc) {
    Write-Output "Copying assets..."
    Copy-Item -Recurse -Force $assetSrc (Join-Path $OutDir 'assets')
}

# Helper: convert PHP file to static HTML by stripping <?php ... ?> blocks and adjusting root-relative paths
function Convert-PHPToHTML($srcFile, $destFile) {
    $text = Get-Content $srcFile -Raw -ErrorAction Stop
    # Remove PHP blocks
    $text = [regex]::Replace($text, '<\?php[\s\S]*?\?>', '', 'Singleline')
    # Normalize root-relative paths to relative paths
    $text = $text -replace 'href="/', 'href="./'
    $text = $text -replace "href='/", "href='./"
    $text = $text -replace 'src="/', 'src="./'
    $text = $text -replace "src='/", "src='./"
    # Turn form actions starting with / into harmless '#' (no server-side on Pages)
    $text = $text -replace 'action="/', 'action="#'
    $text = $text -replace "action='/", "action='#"
    # Normalize /assets/ to ./assets/
    $text = $text -replace '/assets/', './assets/'
    # Write out file
    $destDir = Split-Path $destFile -Parent
    if (-Not (Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir -Force | Out-Null }
    Set-Content -Path $destFile -Value $text -Encoding UTF8
    Write-Output "Converted: $srcFile -> $destFile"
}

# Process all .php files in public root -> docs root (preserve subfolders)
 $phpFiles = Get-ChildItem -Path $PublicDir -Recurse -Include *.php -File -ErrorAction SilentlyContinue
 foreach ($f in $phpFiles) {
    $rel = $f.FullName -replace [regex]::Escape($pubPath), ''
    $rel = $rel -replace '^[\\/]+',''
    $rel = $rel -replace '\\','/'
    # Map pages/* to site root HTML names for user-facing pages
    if ($rel -match '^pages/user/(.+)\.php$') {
        $name = $Matches[1]
        $outPathFile = Join-Path $outPath ($name + '.html')
    } elseif ($rel -match '^pages/auth/(.+)\.php$') {
        $name = $Matches[1]
        $outPathFile = Join-Path $outPath ($name + '.html')
    } elseif ($rel -match '^pages/admin/(.+)\.php$') {
        $name = $Matches[1]
        $outPathFile = Join-Path $outPath (Join-Path 'admin' ($name + '.html'))
    } elseif ($rel -match '^index\.php$') {
        $outPathFile = Join-Path $outPath 'index.html'
    } elseif ($rel -match '^404\.php$') {
        $outPathFile = Join-Path $outPath '404.html'
    } else {
        $outPathFile = Join-Path $outPath ($rel -replace '\.php$','.html')
    }
    Convert-PHPToHTML $f.FullName $outPathFile
 }

# Also copy other static files in public root (html, css, js) not under assets
 $static = Get-ChildItem -Path $PublicDir -Recurse -Include *.html,*.css,*.js,*.png,*.jpg,*.svg,*.ico -File -ErrorAction SilentlyContinue
 foreach ($s in $static) {
     $rel = $s.FullName -replace [regex]::Escape($pubPath), ''
     $rel = $rel -replace '^[\\/]+',''
     $rel = $rel -replace '\\','/'
     $dest = Join-Path $outPath $rel
     $destDir = Split-Path $dest -Parent
     if (-Not (Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir -Force | Out-Null }
     Copy-Item -Force $s.FullName $dest
 }

Write-Output "Static build complete. Output: $outPath"
Write-Output "Note: dynamic PHP endpoints were disabled; forms now point to '#' and server-side features will not work on GitHub Pages."