<?php

namespace Controller;

use Model\Post;
use Src\Request;
use Src\View;
use Model\User;
use Src\Auth\Auth;
use Src\Validator\Validator;

class Site
{
    public function index(Request $request): string
    {
        $posts = Post::where('id', $request->id)->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'Добро пожаловать!']);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if($validator->fails()){
                return new View('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function uploadAvatar(Request $request): string
    {
        if ($request->method === 'POST') {
            try {
                // Валидация файла
                $validator = new Validator($request->all(), [
                    'avatar' => ['required', 'image']
                ], [
                    'required' => 'Выберите файл для загрузки',
                    'image' => 'Допустимы только JPG, PNG или GIF до 2MB'
                ]);

                if ($validator->fails()) {
                    throw new \Exception(implode(', ', $validator->errors()['avatar'] ?? []));
                }

                $user = Auth::user();
                $file = $request->file('avatar');

                // Определяем путь загрузки
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/public/avatars/';
                $relativePath = 'avatars/'; // Для хранения в БД

                // Удаляем старый аватар
                if ($user->avatar && file_exists($uploadDir . $user->avatar)) {
                    unlink($uploadDir . $user->avatar);
                }

                // Генерируем уникальное имя файла
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;
                $targetPath = $uploadDir . $filename;

                // Проверяем существование папки и создаём, если её нет
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0775, true);
                }

                // Перемещаем файл
                if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                    throw new \Exception("Не удалось сохранить файл");
                }

                // Сохраняем путь в БД (относительный путь)
                $user->avatar = $filename;
                $user->save();

                app()->route->redirect('/hello');

            } catch (\Exception $e) {
                return new View('site.hello', [
                    'message' => $e->getMessage(),
                    'user' => Auth::user()
                ]);
            }
        }

        return new View('site.hello', ['user' => Auth::user()]);
    }
}