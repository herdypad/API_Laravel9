<?php

namespace App\Http\Controllers\api;

use App\Helpers\ApiFormater;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudenResource;
use App\Models\Students;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class StudensController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','User']]);
    }

    public function User()
    {

        //pagination only in query not in elequen

        //mengunakan query builder
        // $data = DB::select(DB::raw('select * from students'));
        // $maxPage = 2;
        // $page1 = new Paginator($data, $maxPage);


        // $data = User::all();
        // $maxPage =2;
        // $page1 = new Paginator($data, $maxPage);


        //mengunakan elequen
        $data = Students::all()->toQuery()->paginate(2);

        // dd($data2);
        return new StudenResource(true,'Data Students', $data);
    }

    public function studentSearch(Request $request)
    {

        $fullname = $request->get('fullname');
        $idnumber = $request->get('idnumber');
        $address = $request->get('address');

        //mengunakan manual query builder
        // $query = DB::select(DB::raw('select * from students where fullname like ? '), [$fullname]);
        // // dd($query);
        // $maxPage = 2;
        // $data = new Paginator($query, $maxPage);


        $data = Students::where('fullname', 'like', "%{$fullname}%")
                ->orWhere('idnumber', 'like', "%{$idnumber}%" )
                ->orWhere('address', 'like', "%{$address}%" )
                ->paginate(2);


        // dd($data);
        return new StudenResource(true,'Data Students', $data);
    }

    /**
     * @OA\Get(
     *     path="/api/students",
     *     tags={"students"},
     *     summary="Get all student for REST API",
     *     description="Multiple status values can be provided with comma separated string",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function index()
    {
        $students = Students::all();

        return new StudenResource(true,'Data Students', $students);
    }


    /**
     * @OA\Post(
     *     path="/api/students",
     *     tags={"students"},
     *     summary="Post Create Studen",
     *     description="Multiple status values can be provided with comma separated string",
     *     security={{"bearer":{}}},
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="idnumber",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="fullname",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="address",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "idnumber":"",
     *                     "fullname":"",
     *                     "address":""
     *                }
     *             )
     *         )
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     * )
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $student = Students::create([
                'idnumber' => $request->idnumber,
                'fullname' => $request->fullname,
                'address' => $request->address,

            ]);
            $data = Students::where('id', '=', $student->id)->get();
            return new StudenResource(true,"Data Berhasil Disimpan", $data);
        } catch (Exception $error) {
            return new ApiFormater(false,"Data gagal Disimpan", $error);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $students = Students::find($id);
        if ($students) {
            return new StudenResource(true, 'Data Ditemukan', $students);
        }else {
            return response()->json([
                'message' => 'Data Tidak Ditemukan'
            ],422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $students = Students::find($id);


        if ($students) {

            $students->fullname = $request->fullname;
            $students->gender = $request->gender;
            $students->address = $request->address;
            $students->save();

            return new StudenResource(true, 'Data Berhasil Disimpan', $students);

        }else {
            return response()->json([
                'message' => 'Data Tidak Ditemukan'
            ],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $students = Students::find($id);
        if ($students) {
            $students->delete();
            return new StudenResource(true, 'Data Berhasil Dihapus', $students);
        }else {
            return response()->json([
                'message' => 'Data Tidak Ditemukan'
            ],422);
        }
    }
}
