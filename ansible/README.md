# Ansible — Server Provisioning

Playbook untuk provisioning server baru: **Nginx + PHP 8.4 FPM + Certbot/SSL + Docker + MariaDB**.

---

## Prerequisites

- **Ansible** terinstall di lokal (`brew install ansible` atau `pip install ansible`)
- Server target dengan **Ubuntu 22.04 / 24.04**, akses **root** atau user dengan `sudo`
- SSH key sudah terdaftar di server target

---

## 1. Setup Variables (Hanya 1 File!)

Semua konfigurasi — termasuk **IP server** — di satu file: `group_vars/all.yml`

```yaml
# === Connection ===
ansible_host: 203.0.113.10       # <-- ganti dengan IP server
ansible_user: root                # <-- ganti jika bukan root
# ansible_ssh_private_key_file: ~/.ssh/id_rsa

# Domain
nginx_server_name: app.example.com
certbot_email: admin@example.com
certbot_domains:
  - app.example.com

# Database
mariadb_database: jdd_app
mariadb_user: jdd_user
mariadb_password: "isi_password_kuat"       # <-- ganti
mariadb_root_password: "isi_root_password"  # <-- ganti
```

> **Security:** Untuk production, simpan password di **Ansible Vault**:
> ```bash
> ansible-vault encrypt group_vars/all.yml
> ```

---

## 2. Test Koneksi

```bash
ansible all -i inventory.yml -m ping
```

Hasil:

```json
server | SUCCESS => {
    "ansible_facts": {
        "discovered_interpreter": "/usr/bin/python3"
    },
    "changed": false,
    "ping": "pong"
}
```

---

## 3. Jalankan Playbook

### Full Provisioning

```bash
ansible-playbook -i inventory.yml playbooks/setup.yml
```

### Per Role

```bash
ansible-playbook -i inventory.yml playbooks/setup.yml --tags nginx
ansible-playbook -i inventory.yml playbooks/setup.yml --tags php
ansible-playbook -i inventory.yml playbooks/setup.yml --tags certbot
ansible-playbook -i inventory.yml playbooks/setup.yml --tags docker
```

### Dengan Ansible Vault

```bash
ansible-playbook -i inventory.yml playbooks/setup.yml --ask-vault-pass
```

---

## 4. Verifikasi di Server

SSH ke server dan cek:

```bash
# Nginx
curl -I http://localhost

# PHP
php -v
systemctl status php8.4-fpm

# Docker + MariaDB
docker ps
docker compose -f /opt/docker/docker-compose.yml ps
mysql -h 127.0.0.1 -u jdd_user -p -e "SHOW DATABASES;"
```

---

## 5. SSL Auto-Renewal

```bash
systemctl status certbot-renew.timer
certbot renew --dry-run
```

---

## Struktur File

```
ansible/
├── ansible.cfg
├── inventory.yml                    # Hanya define host name
├── group_vars/
│   └── all.yml                      # Semua variable + IP server
├── playbooks/
│   └── setup.yml
└── roles/
    ├── nginx/
    ├── php/
    ├── certbot/
    └── docker/
```

---

## Rollback

```bash
# Hapus MariaDB
docker compose -f /opt/docker/docker-compose.yml down -v

# Nonaktifkan Nginx site
rm /etc/nginx/sites-enabled/app.conf
systemctl reload nginx
```
