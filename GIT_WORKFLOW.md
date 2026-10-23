# Git Workflow Guide — Khel Sathi

## Branch Structure

| Branch | Purpose |
|--------|---------|
| `main` | Production / main code |
| `sufal` | Sufal's development branch |
| `pravin` | Pravin's development branch |

---

## Setup (One Time Per Developer)

```bash
git clone <repo-url>
git checkout sufal      # Sufal runs this
# OR
git checkout pravin     # Pravin runs this
```

---

## Daily Workflow

### Step 1 — Developer Works and Pushes Code

**Sufal (on his machine):**
```bash
git checkout sufal
git pull origin sufal

# ... write code ...

git add .
git commit -m "your message"
git push origin sufal
```

**Pravin (on his machine):**
```bash
git checkout pravin
git pull origin pravin

# ... write code ...

git add .
git commit -m "your message"
git push origin pravin
```

---

### Step 2 — Manager Merges into Main

When a developer says their feature is ready:

```bash
git checkout main
git pull origin main

git merge origin/sufal      # merge Sufal's code
# OR
git merge origin/pravin     # merge Pravin's code

git push origin main
```

> If both are ready at the same time, merge one then the other.

---

### Step 3 — Resync Dev Branches with Main

After merging into main, always sync both branches:

```bash
git push origin origin/main:sufal --force
git push origin origin/main:pravin --force
```

Then **tell developers to reset on their machine:**

```bash
git fetch origin
git reset --hard origin/sufal     # Sufal runs this
# OR
git reset --hard origin/pravin    # Pravin runs this
```

---

## Full Flow Summary

```
Sufal codes  →  push to sufal branch
Pravin codes →  push to pravin branch
                        ↓
          Manager merges into main → push main
                        ↓
     Manager force syncs sufal + pravin = main
                        ↓
        Developers reset --hard on their machines
                        ↓
                      Repeat
```

---

## Quick Reference

| Action | Command |
|--------|---------|
| Merge Sufal into main | `git merge origin/sufal` |
| Merge Pravin into main | `git merge origin/pravin` |
| Sync sufal to main | `git push origin origin/main:sufal --force` |
| Sync pravin to main | `git push origin origin/main:pravin --force` |
| Developer resync (Sufal) | `git reset --hard origin/sufal` |
| Developer resync (Pravin) | `git reset --hard origin/pravin` |
| Check branch status | `git log --oneline --graph --all` |
