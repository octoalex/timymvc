<?php


namespace Models;


use Core\Model;

class Client extends Model
{


    public function getClient(string $login, string $password)
    {
        $hashPassword = md5($password);
        $stmt = $this->db->prepare("SELECT * FROM public.clients WHERE login = :login");
        $stmt->bindParam('login', $login);
        $stmt->execute();
        if ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if ($result['password'] === $hashPassword){
                return $result;
            }
            else
                return false;
        } else {
            return false;
        }
    }

    public function registerClient(array $data)
    {
        $errors = [];
        if (strlen($data['login']) >= 5) {
            if ($this->checkLoginExist($data['login'])) {
                if (strlen($data['password']) >= 6) {
                    if ($this->checkEmailExist($data['email'])) {
                        $data['password'] = md5($data['password']);
                        $stmt = $this->db->prepare("INSERT INTO public.clients(login, password, email, name, surname, phone, image, address)" .
                            " VALUES(:login,:password,:email,:name,:surname,:phone,:image,:address)");
                        $stmt->execute($data);
                    } else {
                        $errors[] = "Данный email уже используется";
                    }
                } else {
                    $errors[] = "Слишком короткий пароль";
                }
            } else {
                $errors[] = "Данный логин уже используется";
            }
        } else {
            echo 1;
            $errors[] = "Слишком короткий логин";
        }
        if (count($errors) > 0) {
            return ['status' => false,
                'errors' => $errors];
        } else {
            return ['status' => true];
        }
    }
    public function registerAdminClient(array $data)
    {
        $errors = [];
        if (strlen($data['login']) >= 5) {
            if ($this->checkLoginExist($data['login'])) {
                if (strlen($data['password']) >= 6) {
                    if ($this->checkEmailExist($data['email'])) {
                        $data['password'] = md5($data['password']);
                        $stmt = $this->db->prepare("INSERT INTO public.clients(login, password, email, name, surname, phone, image, address,active,club_type)" .
                            " VALUES(:login,:password,:email,:name,:surname,:phone,:image,:address,:active,:club_type)");
                        $stmt->execute($data);
                    } else {
                        $errors[] = "Данный email уже используется";
                    }
                } else {
                    $errors[] = "Слишком короткий пароль";
                }
            } else {
                $errors[] = "Данный логин уже используется";
            }
        } else {
            echo 1;
            $errors[] = "Слишком короткий логин";
        }
        if (count($errors) > 0) {
            return ['status' => false,
                'errors' => $errors];
        } else {
            return ['status' => true];
        }
    }




    public function updateClient(array $data, int $id)
    {
        $errors = [];
        $existUser = $this->getClientById($id);
        if (strlen($data['login']) >= 5) {
            if ($data['login'] !== $existUser['login']) {
                if (!$this->checkLoginExist($data['login'])) {
                    $errors[] = "Данный логин уже используется";
                }
            } else {
                if (strlen($data['password']) >= 6) {
                    if ($data['email'] !== $existUser['email']) {
                        if (!$this->checkEmailExist($data['email'])) {
                            $errors[] = "Данный email уже используется";
                        }
                    } else {
                        $data['password'] = md5($data['password']);
                        $data['id'] = $id;
                        if (!isset($data['image'])) {
                            $data['image'] = $existUser['image'];
                        }
                        $old_photo = $data['old_photo'];
                        unset($data['old_photo']);
                        unlink(ROOT . '/public/repository/photos/' . $old_photo);
                        unlink(ROOT . '/public/repository/thumbs/' . $old_photo);
                        $stmt = $this->db->prepare("UPDATE public.clients SET login =:login, " .
                            "password=:password,email = :email, name =:name, surname=:surname," .
                            " phone=:phone, image=:image, address=:address,active=:active,club_type=:club_type " .
                            " WHERE id=:id");
                        $stmt->execute($data);


                    }
                } else {
                    $errors[] = "Слишком короткий пароль";
                }
            }
        } else {
            echo 1;
            $errors[] = "Слишком короткий логин";
        }
        if (count($errors) > 0) {
            return ['status' => false,
                'errors' => $errors];
        } else {
            return ['status' => true];
        }
    }


    public function checkLoginExist(string $login): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM public.clients WHERE login = :login");
        $stmt->bindParam('login', $login);
        $stmt->execute();
        if ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        } else {
            return true;
        }
    }

    public function getClientsCount()
    {
        $stmt = $this->db->query('SELECT COUNT(*) FROM public.clients');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC)[0]['count'];
    }

    public function checkEmailExist(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM public.clients WHERE email = :email");
        $stmt->bindParam('email', $email);
        $stmt->execute();
        if ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        } else {
            return true;
        }
    }

    public function getClientById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM public.clients WHERE id = :id");
        $stmt->bindParam('id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getForDashboard(int $limit = null, int $page = null)
    {
        $query = 'SELECT id, login, name,surname, email,date_create, active,club_type FROM public.clients ORDER BY id';
        if ($limit) {
            $query .= ' LIMIT ' . $limit;
        }
        if ($page) {
            if ($page === 1) {
                $offset = 0;
            } else {
                $offset = $page * $limit - $limit;
            }
            $query .= ' OFFSET ' . $offset;
        }

        $stmt = $this->db->query($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function deleteById(int $id){
        $stmt = $this->db->prepare("DELETE FROM public.clients WHERE id=:id");
        $stmt->execute(['id'=>$id]);
    }

}