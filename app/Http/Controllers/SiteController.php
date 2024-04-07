<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\SiteLog;
use App\Rules\CronExpressionRule;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $sites = Site::with('log')->get();
            foreach ($sites as $key => $site) {
                $sites[$key]['status'] = $site->log->status;
                unset($sites[$key]['log']);
            }
            return DataTables::of($sites)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $status = '<i class="fa fa-chevron-circle-' . ($row->status ? 'up text-success' : 'down text-danger') . ' fa-3x"></i>';
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<form action="' . route('site-monitor.destroy', $row->id) . '" method="POST">' . csrf_field() . method_field("DELETE") . '<button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    <button type="button" class="btn btn-info btn-sm" onclick="openModal(this)" data-type="edit" data-id="' . $row->id . '" data-url="' . $row->url . '" data-frequency="' . $row->frequency . '"><i class="fa fa-edit"></i></button></form>';
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|string|url',
            'frequency' => ['required' => new CronExpressionRule]
        ]);
        if ($validator->fails())
            return response()->json([
                'error' => $validator->errors()->first(),
                'status' => false
            ], 400);
        $site = Site::create([
            'url' => $request->url,
            'frequency' => $request->frequency
        ]);
        $this->checkSite($site);
        return response()->json([
            'error' => false,
            'status' => true,
            'message' => 'site added for monitoring'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        $validator = Validator::make($data, [
            'id' => 'required|exists:sites,id',
            'url' => 'required|string|url|unique:sites,url,' . $id,
            'frequency' => ['required' => new CronExpressionRule]
        ]);
        if ($validator->fails())
            return response()->json([
                'error' => $validator->errors()->first(),
                'status' => false
            ], 400);
        Site::where(['id' => $id])->update([
            'url' => $request->url,
            'frequency' => $request->frequency
        ]);
        return response()->json([
            'error' => false,
            'status' => true,
            'message' => 'site updated for monitoring'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Int  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $site = Site::findOrFail($id);
        $site->delete();
        return redirect()->route('dashboard')->with('success', 'site deleted successfully');
    }

    public function dashboard()
    {
        return $this->index();
    }

    public function checkSite($site)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', $site->url);
            $statusCode = $response->getStatusCode();
            SiteLog::create([
                'site_id' => $site->id,
                'status' => true,
                'status_code' => $statusCode,
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                SiteLog::create([
                    'site_id' => $site->id,
                    'status' => false,
                    'status_code' => $statusCode,
                ]);
            }
        } catch (\Exception $e) {
            SiteLog::create([
                'site_id' => $site->id,
                'status' => false,
                'status_code' => 500,
            ]);
        }
    }

    public function checkSites($output)
    {
        $sites = Site::all();
        foreach ($sites as $site) {
            $output->info("running info check for site $site->url");
            $this->checkSite($site);
        }
    }
}
